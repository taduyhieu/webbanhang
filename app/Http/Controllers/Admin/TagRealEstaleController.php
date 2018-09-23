<?php

namespace Fully\Http\Controllers\Admin;

use View;
use Flash;
use Input;
use Config;
use Response;
use Illuminate\Http\Request;
use Fully\Services\Pagination;
use Fully\Http\Controllers\Controller;
use Fully\Repositories\TagRealEstale\TagRealEstaleInterface;
use Fully\Exceptions\Validation\ValidationException;
use Exception;

/**
 * Class TagRealEstaleController.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class TagRealEstaleController extends Controller {

    protected $tagRealEstale;
    protected $perPage;

    public function __construct(TagRealEstaleInterface $tagRealEstale) {
        $this->tagRealEstale = $tagRealEstale;
        $this->perPage = config('fully.per_page');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $pagiData = $this->tagRealEstale->paginate(Input::get('page', 1), $this->perPage, true);
        $tagRealEstales = Pagination::makeLengthAware($pagiData->items, $pagiData->totalItems, $this->perPage);
        foreach ($tagRealEstales as $tag) {
            if ($tag->tag_parent_id != 0) {
                $tag->tagParentName = $tag->getTagParent->name;
            }
        }
        return view('backend.tag_real_estale.index', compact('tagRealEstales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $tagParent = $this->tagRealEstale->getTagParent();
        return view('backend.tag_real_estale.create', compact('tagParent'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required|unique:tag_realestale,name',
                ], [
            'name.required' => 'Bắt buộc nhập tiêu đề',
            'name.unique' => 'Tiêu đề đã tồn tại trong cơ sở dữ liệu',
        ]);
        try {
            $this->tagRealEstale->create(Input::all());
            Flash::message(trans('fully.mes_add_succes'));

            return langRedirectRoute('admin.realestale-tag.index');
        } catch (Exception $e) {
            return langRedirectRoute('admin.realestale-tag.create')->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id) {
        $tagRealEstale = $this->tagRealEstale->find($id);
        $tagParent = $this->tagRealEstale->getTagParent();
        
        return view('backend.tag_real_estale.edit', compact('tagRealEstale', 'tagParent'));
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
            'name' => 'required|unique:tag_realestale,name,' . $id
                ], [
            'name.required' => 'Bắt buộc nhập tiêu đề',
            'name.unique' => 'Tiêu đề đã tồn tại trong cơ sở dữ liệu',
        ]);
        try {
            $this->tagRealEstale->update($id, Input::all());
            Flash::message(trans('fully.mes_update_succes'));

            return langRedirectRoute('admin.realestale-tag.index');
        } catch (ValidationException $e) {
            return langRedirectRoute('admin.realestale-tag.edit')->withInput()->withErrors($e->getErrors());
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
        $this->tagRealEstale->delete($id);
        Flash::message(trans('fully.mes_del_succes'));

        return langRedirectRoute('admin.realestale-tag.index');
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function confirmDestroy($id) {
        $tagRealEstale = $this->tagRealEstale->find($id);

        return view('backend.tag_real_estale.confirm-destroy', compact('tagRealEstale'));
    }

}
