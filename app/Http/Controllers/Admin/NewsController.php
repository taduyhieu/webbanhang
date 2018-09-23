<?php

namespace Fully\Http\Controllers\Admin;

use View;
use Input;
use Flash;
use Response;
use Fully\Models\Category;
use Fully\Models\User;
use Fully\Models\Tag;
use Fully\Models\News;
use Illuminate\Http\Request;
use Fully\Services\Pagination;
use Fully\Http\Controllers\Controller;
use Fully\Repositories\News\NewsInterface;
use Fully\Repositories\Category\CategoryInterface;
use Fully\Repositories\Author\AuthorInterface;
use Fully\Exceptions\Validation\ValidationException;
use Fully\Repositories\Comment\CommentInterface;

/**
 * Class NewsController.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class NewsController extends Controller {

    protected $news;
    protected $perPage;

    public function __construct(NewsInterface $news, CategoryInterface $category, AuthorInterface $author, CommentInterface $comment) {
        View::share('active', 'modules');
        $this->news = $news;
        $this->category = $category;
        $this->author = $author;
        $this->comment = $comment;
        $this->perPage = config('fully.modules.news.per_page');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $searchTitle = "";
        $pagiData = $this->news->paginate(Input::get('page', 1), $this->perPage, true);
        $news = Pagination::makeLengthAware($pagiData->items, $pagiData->totalItems, $this->perPage);
        $cate = Category::get();
        return view('backend.news.index', compact('news', 'searchTitle', 'cate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $categories = $this->category->getCategoryAll();
        $authors = $this->author->lists();

        return view('backend.news.create', compact('categories', 'authors'));
    }

    public function getListTag(Request $request) {
        $term = $request->term;
        $tags = Tag::where('name', 'LIKE', $term . '%')->take(50)->select('id', 'name', 'slug')->get();

        return Response::JSON($tags);
    }
    
    public function getListNewsRelation(Request $request) {
        $term = $request->term;
        $newsRealation = News::where('news_title', 'LIKE', $term . '%')->take(50)->select('news_id', 'news_title', 'slug')->get();
        return Response::JSON($newsRealation);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'news_title' => 'required|unique:news,news_title',
            'news_content' => 'required',
            'cat_id' => 'required',
                ], [
            'news_title.required' => 'Tiêu đề không để trống',
            'news_content.required' => 'Nội dung không để trống',
            'cat_id.required' => 'Chưa chọn danh mục',
            'news_title.unique' => 'Tiêu đề đã tồn tại'
        ]);
        try {
            $message = $this->news->create(Input::all());
            Flash::message($message);

            return langRedirectRoute('admin.news.index');
        } catch (ValidationException $e) {
            return langRedirectRoute('admin.news.create')->withInput()->withErrors($e->getErrors());
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
        $news = $this->news->find($id);
        $newsCreater = User::where('id', $news->news_creater)->first();
        $newsAuthor = $this->author->getNewsAuthor($news->news_author);
        $newsApprover = User::where('id', $news->news_approver)->first();

        return view('backend.news.show', compact('news', 'newsCreater', 'newsAuthor', 'newsApprover'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id) {
        $news = $this->news->find($id);
        $categories = $this->category->getCategoryAll();
        $authors = $this->author->lists();
        $tagNews = $news->getTagNews;

        $listNewsRelation = [];
        $listNewsId = explode(",", $news->news_relation);
        foreach ($listNewsId as $id) {
            $listNewsRelation[] = News::where('news_id', $id)->select('news_id', 'news_title', 'slug')->first();
        }

        $listTags = [];
        foreach ($tagNews as $tn) {
            $listTags[] = $tn->getTag;
        }

        $metaData = $news->getMetaData;
        $newsHLExist = $news->getNewsHighLights;
        $newsHomeExist = $news->getNewsHome;
        $newsCateExist = $news->getNewsCate;
        $newsLensREExist = $news->getNewsLensRE;
        $newsFollowExist = $news->getFollowNews;

        return view('backend.news.edit', compact('news', 'categories', 'authors', 'listTags', 'listNewsRelation', 'metaData', 'newsHLExist', 'newsHomeExist', 'newsCateExist', 'newsLensREExist', 'newsFollowExist'));
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
            'news_title' => 'required|unique:news,news_title,' . $id . ',news_id',
            'news_content' => 'required',
            'cat_id' => 'required',
                ], [
            'news_title.required' => 'Tiêu đề không để trống',
            'news_content.required' => 'Nội dung không để trống',
            'cat_id.required' => 'Chưa chọn danh mục',
            'news_title.unique' => 'Tiêu đề đã tồn tại'
        ]);
        try {
            $message = $this->news->update($id, Input::all());
            Flash::message($message);

            return langRedirectRoute('admin.news.index');
        } catch (ValidationException $e) {
            return langRedirectRoute('admin.news.edit')->withInput()->withErrors($e->getErrors());
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
        $this->news->delete($id);
        Flash::message(trans('fully.mes_del_succes'));

        return langRedirectRoute('admin.news.index');
    }

    public function confirmDestroy($id) {
        $news = $this->news->find($id);

        return view('backend.news.confirm-destroy', compact('news'));
    }

    public function togglePublish($id) {
        return $this->news->togglePublish($id);
    }

    public function togglePublishComment($id) {
        return $this->news->togglePublishComment($id);
    }

    public function search(Request $request) {
        $statusId =  $request->status_id;
        $cate = Category::get();
        $catId = $request->cat_id;
        $searchTitle = $request->title_new;
        if ($statusId != "" && $catId != "" && isset($searchTitle)) {
            $news = $this->news->searchNewsByStatusAndCateAndName($statusId, $catId, $searchTitle);
        }
        else if ($catId != "" && isset($searchTitle)) {
            $news = $this->news->searchNewsByCateAndName($catId, $searchTitle);
        }
        else if ($statusId != "" && isset($searchTitle)) {
            $news = $this->news->searchNewsByStatusAndName($statusId, $searchTitle);
        }
        else if ($statusId != "") {
            $news = $this->news->searchNewsByStatus($statusId);
        }
        else if ($catId != "") {
            $news = $this->news->searchNewsByCate($catId);
        }
        else if (isset($searchTitle)) {
            $news = $this->news->searchNewsByName($searchTitle);
        }
        $news->appends(['title_new' => $searchTitle]);
        return view('backend.news.index', compact('news', 'searchTitle', 'cate'));
    }

    public function showComments($id) {
        $comments = $this->news->findAllComment($id);
        return view('backend.news.show-comment', compact('comments'));
    }

    public function showDetailComments($id) {
        $comment = $this->comment->find($id);
        return view('backend.news.show-comment-detail', compact('comment'));
    }

    public function editComments($id) {
        $comment = $this->comment->find($id);
        return view('backend.news.edit-comment', compact('comment'));
    }
    
    public function newsHistory($news_id) {
        $compareContent = $this->news->compareNewsHistory($news_id);
        return view('backend.news.news-history', compact('compareContent'));        
    }

}
