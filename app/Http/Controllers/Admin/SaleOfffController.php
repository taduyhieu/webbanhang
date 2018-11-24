<?php

namespace Fully\Http\Controllers\Admin;

use View;
use Input;
use Flash;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Response;
use Fully\Models\Product;
use Fully\Models\SaleOff;
use Illuminate\Http\Request;
use Fully\Services\Pagination;
use Fully\Http\Controllers\Controller;
use Fully\Exceptions\Validation\ValidationException;
use Fully\Repositories\SaleOfff\SaleOfffInterface;
use Fully\Repositories\SaleOfff\SaleOfffRepository;
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
class SaleOfffController extends Controller {

    protected $saleofff;
    protected $category;
    protected $product;
    protected $agency;
    protected $perPage;

    public function __construct(SaleOfffInterface $saleofff, CategoriesInterface $category, AgenciesInterface $agency) {
        $this->saleofff = $saleofff;
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
        $pagiData = $this->saleofff->paginate(Input::get('page', 1), $this->perPage, true);
        $saleofffs = Pagination::makeLengthAware($pagiData->items, $pagiData->totalItems, $this->perPage);
        
        return view('backend.sale_offf.index', compact('saleofffs', 'searchTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $accessories = DB::table('product')->where('product_categories_id', 15)->get();
        $categories = $this->category->all();
        $agencies = $this->agency->all();
        return view('backend.sale_offf.create', compact('accessories', 'categories', 'agencies'));
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
            $this->saleofff->create(Input::all());
            Flash::message(trans('fully.mes_add_succes'));

            return langRedirectRoute('admin.product-sale-off.index');
        } catch (Exception $e) {
            Flash::message(trans('fully.mes_log_general'));
            return langRedirectRoute('admin.product-sale-off.create');//->withInput()->withErrors($e->getErrors())
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
        $saleofff = $this->saleofff->find($id);
        return view('backend.sale_offf.show', compact('saleofff'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id) {
        $product = $this->product->find($id);
        $products = $this->product->all();

        return view('backend.sale_off.edit', compact('product', 'products'));
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
            $this->product->update($id, Input::all());
            Flash::message(trans('fully.mes_update_succes'));

            return langRedirectRoute('admin.product-sale-off.index');
        } catch (Exception $e) {
            Flash::message(trans('fully.mes_add_succes'));
            return langRedirectRoute('admin.product-sale-off.edit')->withInput()->withErrors($e->getErrors());
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

        $this->saleofff = $this->saleofff->find($id);
        $this->saleofff->delete();
        Flash::message(trans('fully.mes_del_succes'));

        return langRedirectRoute('admin.product-sale-off.index');
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function confirmDestroy($id) {
        $saleoff = $this->saleofff->find($id);

        return view('backend.sale_off.confirm-destroy', compact('saleoff'));
    }

    // public function search(Request $request) {
    //     $searchTitle = $request->title_category;
    //     if (isset($searchTitle)) {
    //         $categories = $this->category->searchCatByName($searchTitle);
    //         foreach ($categories as $category) {
    //             if ($category->cat_parent_id !== 0) {
    //                 $subCategory = DB::table('category')
    //                         ->where('id', '=', $category->cat_parent_id)
    //                         ->select('name')
    //                         ->first();
    //                 $category->categoryParent = $subCategory->name;
    //             }
    //         }
    //     }
    //     $categories->appends(['title_category' => $searchTitle]);
    //     return view('backend.sale_off.index', compact('categories', 'searchTitle'));
    // }

    public function togglePublish($id) {
        return $this->saleofff->togglePublish($id);
    }
    public function getCategoryByParentId($id1, $id2){
        return $this->saleofff->getCategoryByParentId($id1, $id2);
    }

}
