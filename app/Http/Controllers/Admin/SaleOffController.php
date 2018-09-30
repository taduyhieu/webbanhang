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
use Fully\Repositories\SaleOff\SaleOffInterface;
use Fully\Repositories\SaleOff\SaleOffRepository;
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
class SaleOffController extends Controller {

    protected $saleoff;
    protected $category;
    protected $product;
    protected $agency;
    protected $perPage;

    public function __construct(SaleOffInterface $saleoff, CategoriesInterface $category, AgenciesInterface $agency, ProductInterface $product) {
        $this->saleoff = $saleoff;
        $this->category = $category;
        $this->product = $product;
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
        $pagiData = $this->saleoff->paginate(Input::get('page', 1), $this->perPage, true);
        // $products = SaleOff::orderBy('created_at', 'DESC')->paginate(5);
        $saleoffs = Pagination::makeLengthAware($pagiData->items, $pagiData->totalItems, $this->perPage);
        foreach ($saleoffs as $value) {
            if ($value->getProduct()) {
                $value->product_name = $value->getProduct()->value('product_name');
                $value->product_code = $value->getProduct()->value('code');
                $value->price = $value->getProduct()->value('price');
            }
            
        }
        
        return view('backend.sale_off.index', compact('saleoffs', 'searchTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $categories = $this->category->all();
        $products = $this->product->all();
        $agencies = $this->agency->all();
        return view('backend.sale_off.create', compact('categories', 'products', 'agencies'));
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
            $this->saleoff->create(Input::all());
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
        $saleoff = $this->saleoff->find($id);
        $saleoff->product_name = $saleoff->getProduct()->value('product_name');
        $saleoff->product_code = $saleoff->getProduct()->value('code');
        $saleoff->price = $saleoff->getProduct()->value('price');
        return view('backend.sale_off.show', compact('saleoff'));
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

        $this->saleoff = $this->saleoff->find($id);
        $this->saleoff->delete();
        Flash::message(trans('fully.mes_del_succes'));

        return langRedirectRoute('admin.product-sale-off.index');
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function confirmDestroy($id) {
        $saleoff = $this->saleoff->find($id);

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
        return $this->saleoff->togglePublish($id);
    }
    public function getCategoryByParentId($id1, $id2){
        return $this->saleoff->getCategoryByParentId($id1, $id2);
    }

}
