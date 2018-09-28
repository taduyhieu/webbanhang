<?php

namespace Fully\Http\Controllers\Admin;

use View;
use Input;
use Flash;
use DB;
use Fully\Models\Product;
use Illuminate\Http\Request;
use Fully\Services\Pagination;
use Fully\Http\Controllers\Controller;
use Fully\Exceptions\Validation\ValidationException;
use Fully\Repositories\Product\ProductInterface;
use Fully\Repositories\Product\ProductRepository;
use Fully\Repositories\Categories\CategoriesInterface;
use Fully\Repositories\Categories\CategoriesRepository;
use Fully\Repositories\Agencies\AgenciesInterface;
use Fully\Repositories\Agencies\AgenciesRepository;
use Exception;

/**
 * Class CategoriesController.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class AgencyController extends Controller {

    protected $product;
    protected $category;
    protected $agency;
    protected $perPage;

    public function __construct(ProductInterface $product, CategoriesInterface $category, AgenciesInterface $agency) {
        $this->product = $product;
        $this->category = $category;
        $this->agency = $agency;
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
        $pagiData = $this->agency->paginate(Input::get('page', 1), $this->perPage, true);
        $agencies = Pagination::makeLengthAware($pagiData->items, $pagiData->totalItems, $this->perPage);

        return view('backend.agency.index', compact('agencies', 'searchTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $categories = $this->category->all();
        return view('backend.agency.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        // $this->validate($request, [
        //     'title' => 'required|min:3|unique:categories',
        //         ], [
        //     'title.required' => trans('fully.val_cat_title_req'),
        //     'title.min' => trans('fully.val_cat_min'),
        //     'title.unique' => trans('fully.val_cat_unique'),
        // ]);
        try {
            $this->agency->create(Input::all());
            Flash::message(trans('fully.mes_add_succes'));

            return langRedirectRoute('admin.agency.index');
        } catch (Exception $e) {
            Flash::message(trans('fully.mes_log_general'));
            return langRedirectRoute('admin.agency.create');//->withInput()->withErrors($e->getErrors())
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
        $agency = $this->agency->find($id);
        return view('backend.agency.show', compact('agency'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id) {
        $agency = $this->agency->find($id);

        return view('backend.agency.edit', compact('agency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update($id, Request $request) {
        try {
            $this->agency->update($id, Input::all());
            Flash::message(trans('fully.mes_update_succes'));

            return langRedirectRoute('admin.agency.index');
        } catch (Exception $e) {
            Flash::message(trans('fully.mes_add_succes'));
            return langRedirectRoute('admin.agency.edit')->withInput()->withErrors($e->getErrors());
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

        $this->agency = $this->agency->find($id);
        $this->agency->delete();
        Flash::message(trans('fully.mes_del_succes'));

        return langRedirectRoute('admin.agency.index');
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function confirmDestroy($id) {
        $agency = $this->agency->find($id);

        return view('backend.agency.confirm-destroy', compact('agency'));
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
        return $this->agency->togglePublish($id);
    }

}
