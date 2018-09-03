<?php

namespace Fully\Composers;

use Fully\Repositories\News\NewsInterface;

/**
 * Class MenuComposer.
 *
 * @author
 */
class ReadsNewsComposer {

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
        $newsReads = $this->news->getNewsReads();
        $view->with('newsReads', $newsReads);
    }
    
}
