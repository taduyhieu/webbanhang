<?php

namespace Fully\Search;

use Fully\Models\News;
use Fully\Models\Article;
use Fully\Models\PhotoGallery;

/**
 * Class Search.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class Search
{
    public function search($search)
    {
        $newsResult = News::search($search)->get()->toArray();
        $articleResult = Article::search($search)->get()->toArray();
        $photoGalleryResult = PhotoGallery::search($search)->get()->toArray();
        $result = array_merge($newsResult, $articleResult, $photoGalleryResult);

        return $result;
    }
}
