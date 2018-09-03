<?php

namespace Fully\Http\Controllers;

use Fully\Repositories\NewsRealEstale\NewsRealEstaleInterface;
use Fully\Repositories\TagRealEstale\TagRealEstaleInterface;
use Fully\Models\TagRealEstale;
use Fully\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Fully\Models\District;
use Input;
use Response;

class NewsRealEstaleController extends Controller {

    /**
     * @var NewsRealEstaleInterface
     */
    protected $newsRealEstale;
    protected $tagRE;
    protected $perPage;

    /**
     * @param NewsInterface $newsRealEstale
     */
    public function __construct(NewsRealEstaleInterface $newsRealEstale, TagRealEstaleInterface $tagRE) {
        $this->newsRealEstale = $newsRealEstale;
        $this->tagRe = $tagRE;
        $this->perPage = config('fully.modules.news.per_page');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $newsRE = $this->newsRealEstale->getListNewsFE();
        $dateNow = date_format(Carbon::now(), "Y-m-d");
        $tagRealEstale = $this->tagRe->getTagParentFrontend();

        return view('frontend.news_real_estale.index', compact('newsRE', 'dateNow', 'tagRealEstale'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug) {
        $newsRE = $this->newsRealEstale->getBySlug($slug);
        $photos = $newsRE->getPhotos()->select('path')->get();
        $catNews = $newsRE->getCategoryRealestale;
        $dateNow = date_format(Carbon::now(), "Y-m-d");
        $listPublished = $this->newsRealEstale->published();

        // Tag
        $tagNewsRE = $newsRE->getTagNewsRealEstales;
        
        foreach ($tagNewsRE as $tn) {
            $tagRE = $tn->getTagRealEstale;
            if ($tagRE->tag_parent_id == 0) {
                $tagREParent = $tagRE;
                $tagREChild = $tagRE->getTagChild;
            } else if ($tagRE->tag_parent_id > 0) {
                $tagREParent = TagRealEstale::where('id', $tagRE->tag_parent_id)->first();
                $tagREChild = $tagREParent->getTagChild;
            }
        }

        if ($newsRE == null) {
            return Response::view('errors.missing', [], 404);
        }

        return view('frontend.news_real_estale.show', compact('newsRE', 'dateNow', 'photos', 'catNews', 'listPublished', 'tagREParent', 'tagREChild'));
    }

    public function search(Request $request) {
        $attributes = $request->all();
        $dateNow = date_format(Carbon::now(), "Y-m-d");
        $newsRE = $this->newsRealEstale->searchNewsFrontend($attributes);

        return view('frontend.news_real_estale.index', compact('newsRE', 'dateNow'));
    }

    // get all district
    public function getListDistrict() {
        try {
            $cityId = Input::get('city_id');
            if (!$cityId) {
                return;
            }
            $district = District::where('city_id', $cityId)->select('id', 'name')->get();
            return Response::json($district);
        } catch (Exception $ex) {
            
        }
    }

    //tag news real estate
    public function getTagNewsRE($slug) {
        $tagRE = $this->tagRe->getTagBySlug($slug);
        $listTagNewsRE = $tagRE->getTagNewsRealEstales;
        foreach ($listTagNewsRE as $tag) {
            if ($tag) {
                $listNewsRE[] = $tag->getNewsRealEstale;
            } else {
                $listNewsRE = [];
            }
        }
        $dateNow = date_format(Carbon::now(), "Y-m-d");
        $tagChild = $tagRE->getTagChild;

        return view('frontend.news_real_estale.tag-index', compact('listNewsRE', 'dateNow', 'tagRE', 'tagChild'));
    }

}
