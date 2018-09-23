<?php

namespace Fully\Http\Controllers;

use Illuminate\Http\Request;
use Fully\Services\Pagination;
use Fully\Repositories\Tag\TagInterface;
use Fully\Repositories\Tag\TagRepository as Tag;

/**
 * Class TagController.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class TagController extends Controller
{
    /**
     * tag repository
     * @var
     */
    protected $tag;

    /**
     * per page
     * @var
     */
    protected $perPage;

    /**
     * TagController constructor.
     * @param TagInterface $tag
     */
    public function __construct(TagInterface $tag)
    {
        $this->tag = $tag;
        $this->perPage = config('fully.modules.video.per_page');
    }

    /**
     * Display a resource by slug
     *
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($slug)
    {
    	$tag = $this->tag->findbySlug($slug);
        $news = $this->tag->getNewByTag($slug);
        return view('frontend.tag.index', compact('news', 'tag'));
    }
}
