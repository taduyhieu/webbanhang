<?php

namespace Fully\Http\Controllers\Admin;

use View;
use Input;
use Flash;
use DB;
use Fully\Models\Product;
use Fully\Models\SaleOfff;
use Fully\Models\SaleOff_Product;

use Illuminate\Http\Request;
use Fully\Services\Pagination;
use Fully\Http\Controllers\Controller;
use Fully\Exceptions\Validation\ValidationException;
use Fully\Repositories\Product\ProductInterface;
use Fully\Repositories\Product\ProductRepository;
use Fully\Repositories\Categories\CategoriesInterface;
use Fully\Repositories\Categories\CategoriesRepository;
use Exception;

/**
 * Class CategoriesController.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class ProductController extends Controller {

    protected $product;
    protected $category;
    protected $perPage;

    public function __construct(ProductInterface $product, CategoriesInterface $category) {
        $this->product = $product;
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
        $pagiData = $this->product->paginate(Input::get('page', 1), $this->perPage, true);
        $products = Pagination::makeLengthAware($pagiData->items, $pagiData->totalItems, $this->perPage);

        return view('backend.product.index', compact('products', 'searchTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $categories = $this->category->all();
        return view('backend.product.create', compact('categories'));
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
            $this->product->create(Input::all());
            Flash::message(trans('fully.mes_add_succes'));

            return langRedirectRoute('admin.product.index');
        } catch (Exception $e) {
            Flash::message(trans('fully.mes_log_general'));
            return langRedirectRoute('admin.product.create');//->withInput()->withErrors($e->getErrors())
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
        $product = $this->product->find($id);
        $product->category_name = $product->getCatProduct()->value('title');
        $product->agency_name = $product->getAgencyProduct()->value('name');
        return view('backend.product.show', compact('product'));
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

        return view('backend.product.edit', compact('product', 'products'));
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

            return langRedirectRoute('admin.product.index');
        } catch (Exception $e) {
            Flash::message(trans('fully.mes_add_succes'));
            return langRedirectRoute('admin.product.edit')->withInput()->withErrors($e->getErrors());
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

        $this->product = $this->product->find($id);
        $this->product->delete();
        Flash::message(trans('fully.mes_del_succes'));

        return langRedirectRoute('admin.product.index');
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function confirmDestroy($id) {
        $product = $this->product->find($id);

        return view('backend.product.confirm-destroy', compact('product'));
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
        return $this->product->togglePublish($id);
    }

    public function getSaleOff(){
        $products = $this->product->all();
        foreach ($products as $product) {
            $product->id_saleoff = $product->getSaleOff;
        }
        foreach ($products as $product) {
            foreach ($product->id_saleoff as $value) {
                $value->name_saleoff = SaleOfff::where('id', $value->id_saleoff)->get()->pluck('name');
            }
        }
        dd($products);
        // foreach ($products as $product) {
        //     echo '<pre>';

        //     foreach ($product->id_saleoff as $value) {
        //          dd($product->id_saleoff->name_saleoff);
        //          echo 'string';
        //     }
        // }
        
    }

}
