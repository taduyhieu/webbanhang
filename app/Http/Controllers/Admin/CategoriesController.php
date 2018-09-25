<?php

namespace Fully\Http\Controllers\Admin;

use View;
use Input;
use Flash;
use DB;
use Fully\Models\Categories as Cate;
use Illuminate\Http\Request;
use Fully\Services\Pagination;
use Fully\Http\Controllers\Controller;
use Fully\Repositories\Categories\CategoriesInterface;
use Fully\Exceptions\Validation\ValidationException;
use Fully\Repositories\Categoryies\CategoriesRepository as Categories;
use Exception;

/**
 * Class CategoriesController.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class CategoriesController extends Controller {

    protected $category;
    protected $perPage;

    public function __construct(CategoriesInterface $category) {
        $this->category = $category;
        View::share('active', 'blog');
        $this->perPage = config('fully.modules.category.per_page');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $searchTitle = "";
        $pagiData = $this->category->paginate(Input::get('page', 1), $this->perPage, true);
        $categories = Pagination::makeLengthAware($pagiData->items, $pagiData->totalItems, $this->perPage);

        foreach ($categories as $category) {
            if ($category->cat_parent_id != null) {
                $category->parent_title = $category->getCatParent()->value('title'); 
            }
            
        }

        return view('backend.categories.index', compact('categories', 'searchTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $categories = $this->category->all();

        return view('backend.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required|min:3|unique:categories',
                ], [
            'title.required' => trans('fully.val_cat_title_req'),
            'title.min' => trans('fully.val_cat_min'),
            'title.unique' => trans('fully.val_cat_unique'),
        ]);
        // try {
            $this->category->create(Input::all());
            Flash::message(trans('fully.mes_add_succes'));

            return langRedirectRoute('admin.categories.index');
        // } catch (Exception $e) {
        //     Flash::message(trans('fully.mes_log_general'));
        //     return langRedirectRoute('admin.categories.create');//->withInput()->withErrors($e->getErrors())
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id) {
        $category = $this->category->find($id);

        if ($category->cat_parent_id != null) {
            $category->parent_title = $category->getCatParent()->value('title'); 
        }
        return view('backend.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id) {
        $category = $this->category->find($id);
        $categories = $this->category->all();
        if ($category->cat_parent_id != null) {
            $category->parent_title = $category->getCatParent()->value('title'); 
        }

        return view('backend.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update($id, Request $request) {
        $this->validate($request, [
            'title' => 'required|min:3|unique:categories,title,' . $id,
                ], [
            'title.required' => trans('fully.val_cat_title_req'),
            'title.min' => trans('fully.val_cat_min'),
            'title.unique' => 'Tên đã tồn tại',
        ]);
        try {
            $this->category->update($id, Input::all());
            Flash::message(trans('fully.mes_update_succes'));

            return langRedirectRoute('admin.categories.index');
        } catch (Exception $e) {
            Flash::message(trans('fully.mes_add_succes'));
            return langRedirectRoute('admin.categories.edit')->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id) {
        if ($this->category->hasChildItems($id)) {
            Flash::message(trans('fully.mes_category_log_1'));
            return langRedirectRoute('admin.categories.index');
        }
        $checkNews = DB::table('news')->where('cat_id', $id)->get();

        if ($checkNews != null) {
            Flash::message(trans('fully.mes_category_log_2'));
            return langRedirectRoute('admin.categories.index');
        }

        $this->category = $this->category->find($id);
        $this->category->delete();
        Flash::message(trans('fully.mes_del_succes'));

        return langRedirectRoute('admin.categories.index');
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function confirmDestroy($id) {
        $category = $this->category->find($id);

        return view('backend.categories.confirm-destroy', compact('category'));
    }

    public function search(Request $request) {
        $searchTitle = $request->title_category;
        if (isset($searchTitle)) {
            $categories = $this->category->searchCatByName($searchTitle);
            foreach ($categories as $category) {
                if ($category->cat_parent_id !== 0) {
                    $subCategory = DB::table('category')
                            ->where('id', '=', $category->cat_parent_id)
                            ->select('name')
                            ->first();
                    $category->categoryParent = $subCategory->name;
                }
            }
        }
        $categories->appends(['title_category' => $searchTitle]);
        return view('backend.category.index', compact('categories', 'searchTitle'));
    }

    public function togglePublish($id) {
        return $this->category->togglePublish($id);
    }

}
