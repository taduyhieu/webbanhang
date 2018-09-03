<?php

namespace Fully\Http\Controllers\Admin;

use Fully\Models\User;
use Input;
use Flash;
use Fully\Services\Pagination;
use Illuminate\Http\Request;
use Fully\Http\Controllers\Controller;
use Fully\Repositories\Author\AuthorInterface;
use Fully\Exceptions\Validation\ValidationException;

class AuthorController extends Controller {

    protected $author;
    protected $perPage;

    public function __construct(AuthorInterface $author) {
        $this->author = $author;
        $this->perPage = config('fully.per_page');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $pagiData = $this->author->paginate(Input::get('page', 1), $this->perPage, true);
        $authors = Pagination::makeLengthAware($pagiData->items, $pagiData->totalItems, $this->perPage);

        return view('backend.author.index', compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $users = User::lists('full_name', 'id');

        return view('backend.author.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required',
                ], [
            'name.required' => 'Tên tác giả không được để trống',
        ]);
        try {
            $this->author->create(Input::all());
            Flash::message('Thêm mới thành công');

            return langRedirectRoute('admin.author.index');
        } catch (ValidationException $e) {
            return langRedirectRoute('admin.author.create')->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $author = $this->author->find($id);
        
        return view('backend.author.show', compact('author', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $author = $this->author->find($id);
        $users = User::lists('full_name', 'id');
        return view('backend.author.edit', compact('author', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
                ], [
            'name.required' => 'Tên tác giả không được để trống',
        ]);
        try {
            $this->author->update($id, Input::all());
            Flash::message('Sửa thành công');

            return langRedirectRoute('admin.author.index');
        } catch (ValidationException $e) {
            return langRedirectRoute('admin.author.edit')->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $this->author->delete($id);
        Flash::message('Đã xóa thành công');

        return langRedirectRoute('admin.author.index');
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function confirmDestroy($id) {
        $author = $this->author->find($id);

        return view('backend.author.confirm-destroy', compact('author'));
    }

}
