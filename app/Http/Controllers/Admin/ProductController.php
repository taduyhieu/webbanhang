<?php

namespace Fully\Http\Controllers\Admin;

use View;
use Input;
use Flash;
use DB;
use Illuminate\Http\Request;
use Fully\Services\Pagination;
use Fully\Http\Controllers\Controller;
use Fully\Repositories\Product\ProductInterface;
use Fully\Exceptions\Validation\ValidationException;
use Fully\Repositories\Product\ProductRepository as Product;
use Exception;

/**
 * Class CategoriesController.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class ProductController extends Controller {

    protected $category;
    protected $perPage;

    public function __construct(ProductInterface $product) {
        $this->product = $product;
        View::share('active', 'blog');
        $this->perPage = config('fully.modules.product.per_page');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $searchTitle = "";
        $pagiData = $this->category->paginate(Input::get('page', 1), $this->perPage, true);
        $products = Pagination::makeLengthAware($pagiData->items, $pagiData->totalItems, $this->perPage);

        // foreach ($categories as $category) {
        //     if ($category->cat_parent_id != null) {
        //         $category->parent_title = $category->getCatParent()->value('title'); 
        //     }
            
        // }

        return view('backend.product.index', compact('products', 'searchTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        // $categories = $this->product->all();

        return view('backend.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        // $this->validate($request, [
        //     'name' => 'required|min:3|unique:category',
        //     'order' => 'numeric|unique:category,order',
        //         ], [
        //     'name.required' => trans('fully.val_cat_title_req'),
        //     'name.min' => trans('fully.val_cat_min'),
        //     'name.unique' => trans('fully.val_cat_unique'),
        //     'order.numeric' => 'Thứ tự sắp xếp phải là số',
        //     'order.unique' => 'Thứ tự sắp xếp đã tồn tại',
        // ]);
        try {
            $this->product->create(Input::all());
            Flash::message(trans('fully.mes_add_succes'));

            return langRedirectRoute('admin.product.index');
        } catch (Exception $e) {
            Flash::message(trans('fully.mes_log_general'));
            return langRedirectRoute('admin.product.create')->withInput()->withErrors($e->getErrors());
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

        // if ($category->cat_parent_id != null) {
        //     $category->parent_title = $category->getCatParent()->value('title'); 
        // }
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
        // $categories = $this->category->all();
        // if ($category->cat_parent_id != null) {
        //     $category->parent_title = $category->getCatParent()->value('title'); 
        // }

        return view('backend.product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update($id, Request $request) {
        // $this->validate($request, [
        //     'name' => 'required|min:3',
        //     'order' => 'numeric|unique:category,order,' . $id,
        //         ], [
        //     'name.required' => trans('fully.val_cat_title_req'),
        //     'name.min' => trans('fully.val_cat_min'),
        //     'order.numeric' => 'Thứ tự sắp xếp phải là số',
        //     'order.unique' => 'Thứ tự sắp xếp đã tồn tại',
        // ]);
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
        if ($this->product->hasChildItems($id)) {
            Flash::message(trans('fully.mes_category_log_1'));
            return langRedirectRoute('admin.product.index');
        }
        $checkNews = DB::table('news')->where('cat_id', $id)->get();

        if ($checkNews != null) {
            Flash::message(trans('fully.mes_category_log_2'));
            return langRedirectRoute('admin.product.index');
        }

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

}
