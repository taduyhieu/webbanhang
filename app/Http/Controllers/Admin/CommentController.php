<?php

namespace Fully\Http\Controllers\Admin;

use Flash;
use Input;
use Response;
use Carbon\Carbon;
use Fully\Models\Comment;
use Illuminate\Http\Request;
//use Fully\Services\Pagination;
use Fully\Http\Controllers\Controller;
use Fully\Repositories\Comment\CommentInterface;
use Fully\Exceptions\Validation\ValidationException;
use Fully\Repositories\Comment\CommentRepository as Comments;
use Exception;

/**
 * Class CommentController.
 *
 * @author THC <thanhhaconnection@gmail.com>
 */
class CommentController extends Controller {

    protected $comment;
    protected $perPage;

    public function __construct(CommentInterface $comment) {
        $this->comment = $comment;
        $this->perPage = config('fully.per_page');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
//        $pagiData = $this->comment->paginate(Input::get('page', 1), $this->perPage, true);
//        $comments = Pagination::makeLengthAware($pagiData->items, $pagiData->totalItems, $this->perPage);
        $searchTitle = "";
        $comments = Comment::orderBy('post_time', 'DESC')->paginate(10);
        foreach ($comments as $cmt) {
            $cmt->news_title = $cmt->getNews->news_title;
        }
        return view('backend.comment.index', compact('comments', 'searchTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view('backend.comment.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        try {
            $this->comment->create(Input::all());
            Flash::message(trans('fully.mes_add_succes'));

            return langRedirectRoute('admin.comment.index');
        } catch (Exception $e) {
            return langRedirectRoute('admin.comment.create')->withInput()->withErrors($e->getErrors());
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
        $comment = $this->comment->find($id);
        $comment->news_title = $comment->getNews->news_title;

        return view('backend.comment.show', compact('comment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id) {
        $comment = $this->comment->find($id);

        return view('backend.comment.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update($id, Request $request) {
        $this->comment->update($id, Input::all());
        Flash::message(trans('fully.mes_update_succes'));

        return langRedirectRoute('admin.news.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id) {
        $this->comment->delete($id);
        Flash::message(trans('fully.mes_del_succes'));

        return langRedirectRoute('admin.comment.index');
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function confirmDestroy($id) {
        $comment = $this->comment->find($id);

        return view('backend.comment.confirm-destroy', compact('comment'));
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function togglePublish($id){
        return $this->comment->togglePublishComment($id);
    }

    public function search(Request $request) {
        $searchTitle = $request->title_new;
        if (isset($searchTitle)) {
            $comments = Comment::whereHas('getNews', function ($query) use($searchTitle) {
                        $query->where('news_title', 'like', $searchTitle . '%');
                    })->orderBy('post_time', 'DESC')->paginate(10);

            foreach ($comments as $cmt) {
                $cmt->news_title = $cmt->getNews->news_title;
            }
        }
        $comments->appends(['title_new' => $searchTitle]);
        return view('backend.comment.index', compact('comments', 'searchTitle'));
    }

}
