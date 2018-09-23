<?php

namespace Fully\Http\Controllers;

use Illuminate\Http\Request;
use Fully\Repositories\News\NewsInterface;

/**
 * Class NewsController.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class NewsController extends Controller {

    /**
     * @var NewsInterface
     */
    protected $news;
    protected $perPage;

    /**
     * @param NewsInterface $news
     */
    public function __construct(NewsInterface $news) {
        $this->news = $news;
        $this->perPage = config('fully.modules.news.per_page');
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('frontend.news.index');
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($slug) {
        $new = $this->news->getBySlug($slug);

        if ($new) {
            $new->view_count = $new->view_count + 1;
        }
        $new->save();
        $new->cat_name = $new->getCategory->name;
        $listNewsRelation = $this->news->getNewsRelataion($new->news_relation);
        $newsRelation = array_slice($listNewsRelation, 0, 3);
        $tags = $this->news->getTagNews($new->news_id);
        if ($new->type == 1) {
            return view('frontend.news.show', compact('new', 'newsRelation', 'tags'));
        } else
        if ($new->type == 2) {
            return view('frontend.news.emagazine', compact('new'));
        }
    }

}
