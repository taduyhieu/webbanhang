<?php

namespace Fully\Http\Controllers;

use Illuminate\Http\Request;
use Fully\Repositories\Category\CategoryInterface;

/**
 * Class CategoryController.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class CategoryController extends Controller {

    protected $category;
    protected $perPage;

    public function __construct(CategoryInterface $category) {
        $this->category = $category;
        $this->perPage = config('fully.modules.category.per_page');
    }

    /**
     * Display a listing of the resource by slug.
     *
     * @param Request $request 
     * @param $slug
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, $slug) {
        $news = $this->category->getNewsByCate($slug);
        $newsTop = $news[0];
        $newsByCat = $news[1];
        $category = $news[2];
        return view('frontend.category.index', compact('newsTop', 'newsByCat', 'category'));
    }

}
