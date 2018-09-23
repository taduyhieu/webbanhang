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
use Fully\Repositories\Tag\TagInterface;
use Fully\Exceptions\Validation\ValidationException;
use Exception;

/**
 * Class TagController.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class TagController extends Controller {

    protected $tag;
    protected $perPage;

    public function __construct(TagInterface $tag) {
        $this->tag = $tag;
        $this->perPage = config('fully.per_page');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $pagiData = $this->tag->paginate(Input::get('page', 1), $this->perPage, true);
        $tags = Pagination::makeLengthAware($pagiData->items, $pagiData->totalItems, $this->perPage);
        return view('backend.tag.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        
        return view('backend.tag.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required|unique:tag,name',
                ], [
            'name.required' => 'Bắt buộc nhập tiêu đề',
            'name.unique' => 'Tiêu đề đã tồn tại trong cơ sở dữ liệu',
        ]);
        try {
            $this->tag->create(Input::all());
            Flash::message(trans('fully.mes_add_succes'));

            return langRedirectRoute('admin.news-tag.index');
        } catch (Exception $e) {
            return langRedirectRoute('admin.news-tag.create')->withInput()->withErrors($e->getErrors());
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
        $tag = $this->tag->find($id);

        return view('backend.tag.edit', compact('tag'));
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
            'name' => 'required|unique:tag,name,' . $id
                ], [
            'name.required' => 'Bắt buộc nhập tiêu đề',
            'name.unique' => 'Tiêu đề đã tồn tại trong cơ sở dữ liệu',
        ]);
        try {
            $this->tag->update($id, Input::all());
            Flash::message(trans('fully.mes_update_succes'));

            return langRedirectRoute('admin.news-tag.index');
        } catch (ValidationException $e) {
            return langRedirectRoute('admin.news-tag.edit')->withInput()->withErrors($e->getErrors());
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
        $this->tag->delete($id);
        Flash::message(trans('fully.mes_del_succes'));

        return langRedirectRoute('admin.news-tag.index');
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function confirmDestroy($id) {
        $tag = $this->tag->find($id);

        return view('backend.tag.confirm-destroy', compact('tag'));
    }

}
