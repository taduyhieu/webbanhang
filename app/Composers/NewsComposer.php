<?php

namespace Fully\Composers;

use Fully\Models\FollowNews;
use Fully\Repositories\News\NewsInterface;

/**
 * Class MenuComposer.
 *
 * @author
 */
class NewsComposer {

    /**
     * @var \Fully\Repositories\News\NewsInterface
     */
    protected $news;

    /**
     * NewsComposer constructor.
     * @param NewsInterface $news
     */
    public function __construct(NewsInterface $news) {
        $this->news = $news;
    }

    /**
     * @param $view
     */
    public function compose($view) {
        $listFollowNews = FollowNews::orderBy('order', 'ASC')->where('show_type', 1)->take(5)->offset(0)->get();
        foreach ($listFollowNews as $fn) {
            $fn->news_title = $fn->getNews->news_title;
            $fn->news_content = $fn->getNews->news_content;
            $fn->slug = $fn->getNews->slug;
            $fn->news_image = $fn->getNews->news_image;
        }
        
        $newsCommentShow = $this->news->showCommentsHome();

        $news = $this->news->getLastNews(5);
            
        $view->with('news', $news)->with('listFollowNews', $listFollowNews)->with('newsCommentShow', $newsCommentShow);
    }

}
