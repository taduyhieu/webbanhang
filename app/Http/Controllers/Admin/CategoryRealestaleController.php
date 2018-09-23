<?php

namespace Fully\Http\Controllers\Admin;

use Flash;
use Input;
use Config;
use Response;
use VideoApi;
use Fully\Models\CategoryRealestale as CategoryRealestales;
use Illuminate\Http\Request;
use Fully\Services\Pagination;
use Fully\Http\Controllers\Controller;
use Fully\Repositories\CategoryRealestale\CategoryRealestaleInterface;
use Fully\Repositories\CategoryRealestale\CategoryRealestaleRepository as CategoryRealestale;
use Fully\Exceptions\Validation\ValidationException;
use Exception;

/**
 * Class CategoryRealestaleController.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class CategoryRealestaleController extends Controller {

    protected $categoryReal;
    protected $perPage;

    public function __construct(CategoryRealestaleInterface $categoryReal) {
        $this->categoryReal = $categoryReal;
        $this->perPage = config('fully.per_page');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $pagiData = $this->categoryReal->paginate(Input::get('page', 1), $this->perPage, true);
        $categoryRealestales = Pagination::makeLengthAware($pagiData->items, $pagiData->totalItems, $this->perPage);
        foreach ($categoryRealestales as $categoryRealestale) {
            if ($categoryRealestale->parent_id > 0) {
                $categoryParent = CategoryRealestales::where('id', $categoryRealestale->parent_id)->first();
                $categoryRealestale->cateParentName = $categoryParent->name;
            }
        }
        return view('backend.category_realestale.index', compact('categoryRealestales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $pagiData = $this->categoryReal->paginate(Input::get('page', 1), $this->perPage, true);
        $categoryRealestales = Pagination::makeLengthAware($pagiData->items, $pagiData->totalItems, $this->perPage);
        return view('backend.category_realestale.create', compact('categoryRealestales'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required|unique:category_realestale,name',
//            'parent_id' => 'required',
            'order' => 'required',
            'meta_description' => 'required',
            'meta_keyword' => 'required',
                ], [
            'name.required' => 'Bắt buộc nhập tiêu đề',
            'name.unique' => 'Đã tồn tại tiêu đề này',
//            'parent_id.required' => 'Bắt buộc chọn danh mục',
            'order.required' => 'Bắt buộc nhập thứ tự',
            'meta_description.required' => 'Bắt buộc nhập meta description',
            'meta_keyword.required' => 'Bắt buộc nhập meta keyword',
        ]);

        try {
            $this->categoryReal->create(Input::all());
            Flash::message(trans('fully.mes_add_succes'));

            return langRedirectRoute('admin.realestale-category.index');
        } catch (Exception $e) {
            return langRedirectRoute('admin.realestale-category.create')->withInput()->withErrors($e->getErrors());
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
        $categoryrealestale = $this->categoryReal->find($id);
        $parent = $this->categoryReal->getCategoryParent($categoryrealestale->parent_id);
        return view('backend.category_realestale.show', compact('categoryrealestale', 'parent'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id) {
        $categoryrealestale = $this->categoryReal->find($id);
        $categoryrealestales = $this->categoryReal->getCategoryRealEstaleAll();

        return view('backend.category_realestale.edit', compact('categoryrealestale', 'categoryrealestales'));
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
            'name' => 'required|unique:category_realestale,name,' . $id,
//            'parent_id' => 'required',
            'order' => 'required',
            'meta_description' => 'required',
            'meta_keyword' => 'required',
                ], [
            'name.required' => 'Bắt buộc nhập tiêu đề',
            'name.unique' => 'Đã tồn tại tiêu đề này',
//            'parent_id.required' => 'Bắt buộc chọn danh mục',
            'order.required' => 'Bắt buộc nhập thứ tự',
            'meta_description.required' => 'Bắt buộc nhập meta description',
            'meta_keyword.required' => 'Bắt buộc nhập meta keyword',
        ]);
        try {
            $this->categoryReal->update($id, Input::all());
            Flash::message(trans('fully.mes_update_succes'));

            return langRedirectRoute('admin.realestale-category.index');
        } catch (ValidationException $e) {
            return langRedirectRoute('admin.realestale-category.edit')->withInput()->withErrors($e->getErrors());
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
        $this->categoryReal->delete($id);
        Flash::message(trans('fully.mes_del_succes'));

        return langRedirectRoute('admin.realestale-category.index');
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function confirmDestroy($id) {
        $categoryrealestale = $this->categoryReal->find($id);

        return view('backend.category_realestale.confirm-destroy', compact('categoryrealestale'));
    }

}
