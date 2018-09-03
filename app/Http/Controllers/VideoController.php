<?php

namespace Fully\Http\Controllers;

use Illuminate\Http\Request;
use Fully\Services\Pagination;
use Fully\Repositories\Video\VideoInterface;
use Fully\Repositories\Category\CategoryInterface;
use Fully\Repositories\Video\VideoRepository as Video;

/**
 * Class VideoController.
 *
 * @author THC <thanhhaconnection@gmail.com>
 */
class VideoController extends Controller {

    /**
     * video repository
     * @var
     */
    protected $video;

    /**
     * per page
     * @var
     */
    protected $perPage;

    /**
     * VideoController constructor.
     * @param VideoInterface $video
     */
    public function __construct(VideoInterface $video, CategoryInterface $category) {
        $this->video = $video;
        $this->category = $category;
        $this->perPage = config('fully.modules.video.per_page');
    }

    /**
     * Display a listing of the resource
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        $video = $this->video->findFirst();
        $categoryOfVideo = $this->category->getCategory($video->cat_id);
        $video->nameCategory = $categoryOfVideo->name;

        $videos = $this->video->findFirstLimit(14);
        $categories = $this->category->getCategoryByParentId(1012);
        return view('frontend.video.index', compact('videos', 'video', 'categories'));
    }

    /**
     * Display a resource by slug
     *
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($slug) {
        $videos = $this->video->getCategoryBySlug($slug);
        $categories = $this->category->getCategoryByParentId(1012);
        return view('frontend.video.show_category', compact('videos', 'categories'));
    }

    public function showDetail($slug) {
        $video = $this->video->getVideoBySlug($slug);

        $categoryOfVideo = $this->category->getCategory($video->cat_id);
        $video->nameCategory = $categoryOfVideo->name;

        $videos = $this->video->findFirstLimit(14);
        $categories = $this->category->getCategoryByParentId(1012);
        return view('frontend.video.show_detail', compact('videos', 'video', 'categories'));
    }

}
