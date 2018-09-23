<?php

namespace Fully\Http\Controllers\Admin;

use View;
use Input;
use Flash;
use DB;
use Illuminate\Http\Request;
use Fully\Services\Pagination;
use Fully\Http\Controllers\Controller;
use Fully\Repositories\Category\CategoryInterface;
use Fully\Exceptions\Validation\ValidationException;
use Fully\Repositories\Category\CategoryRepository as Category;
use Exception;

/**
 * Class CategoryController.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class CategoryController extends Controller {

    protected $category;
    protected $perPage;

    public function __construct(CategoryInterface $category) {
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
        foreach ($categories as $cat) {
            if ($cat->cat_parent_id != 0) {
                $cat->catParentName = $cat->getCatParent->name;
            }
        }

        return view('backend.category.index', compact('categories', 'searchTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $categories = $this->category->getCatParent();

        foreach ($categories as $category) {
            $subCategory = $this->category->getCatSub($category->id);
            $category->subCategory = $subCategory;
        }

        return view('backend.category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required|min:3|unique:category',
            'order' => 'numeric|unique:category,order',
                ], [
            'name.required' => trans('fully.val_cat_title_req'),
            'name.min' => trans('fully.val_cat_min'),
            'name.unique' => trans('fully.val_cat_unique'),
            'order.numeric' => 'Thứ tự sắp xếp phải là số',
            'order.unique' => 'Thứ tự sắp xếp đã tồn tại',
        ]);
        try {
            $this->category->create(Input::all());
            Flash::message(trans('fully.mes_add_succes'));

            return langRedirectRoute('admin.category.index');
        } catch (Exception $e) {
            Flash::message(trans('fully.mes_log_general'));
            return langRedirectRoute('admin.category.create')->withInput()->withErrors($e->getErrors());
        }
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

        if ($category->cat_parent_id !== 0) {
            $subCategory = DB::table('category')
                    ->where('id', '=', $category->cat_parent_id)
                    ->select('name')
                    ->first();
            $category->categoryParent = $subCategory->name;
        }
        return view('backend.category.show', compact('category'));
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

        $categories = $this->category->getCatParent();
        foreach ($categories as $categoryParent) {
            $subCategory = $this->category->getCatSub($category->id);
            $categoryParent->subCategory = $subCategory;
        }

        return view('backend.category.edit', compact('category', 'categories'));
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
            'name' => 'required|min:3',
            'order' => 'numeric|unique:category,order,' . $id,
                ], [
            'name.required' => trans('fully.val_cat_title_req'),
            'name.min' => trans('fully.val_cat_min'),
            'order.numeric' => 'Thứ tự sắp xếp phải là số',
            'order.unique' => 'Thứ tự sắp xếp đã tồn tại',
        ]);
        try {
            $this->category->update($id, Input::all());
            Flash::message(trans('fully.mes_update_succes'));

            return langRedirectRoute('admin.category.index');
        } catch (Exception $e) {
            Flash::message(trans('fully.mes_add_succes'));
            return langRedirectRoute('admin.category.edit')->withInput()->withErrors($e->getErrors());
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
            return langRedirectRoute('admin.category.index');
        }
        $checkNews = DB::table('news')->where('cat_id', $id)->get();

        if ($checkNews != null) {
            Flash::message(trans('fully.mes_category_log_2'));
            return langRedirectRoute('admin.category.index');
        }

        $this->category = $this->category->find($id);
        $this->category->delete();
        Flash::message(trans('fully.mes_del_succes'));

        return langRedirectRoute('admin.category.index');
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function confirmDestroy($id) {
        $category = $this->category->find($id);

        return view('backend.category.confirm-destroy', compact('category'));
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
