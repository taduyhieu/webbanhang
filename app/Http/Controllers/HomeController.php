<?php

namespace Fully\Http\Controllers;

use Fully\Models\News;
use Fully\Models\NewsHome;
use Fully\Models\NewsHighLight;
use Fully\Models\LensRealEstale;
use Fully\Repositories\Slider\SliderInterface;
use Fully\Repositories\Banner\BannerInterface;
use Fully\Repositories\Category\CategoryInterface;
use Fully\Repositories\NewsRealEstale\NewsRealEstaleInterface;
use LaravelLocalization;
use Illuminate\Http\Request;
use Config;
use Session;

// use Language;

/**
 * Class HomeController.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class HomeController extends Controller {

    protected $slider;
    protected $banner;
    protected $newsRealEstale;

    public function __construct(SliderInterface $slider, CategoryInterface $category, BannerInterface $banner, NewsRealEstaleInterface $newsRealEstale) {
        $this->slider = $slider;
        $this->banner = $banner;
        $this->category = $category;
        $this->newsRealEstale = $newsRealEstale;
        $config = Config::get('fully');
//        $this->email = $config['modules']['email']['send_to'];
    }

    public function index(Request $request) {
        $languages = LaravelLocalization::getSupportedLocales();
        $sliders = $this->slider->all();
        $firstCats = $this->category->getFirstCategory(4);

        foreach ($firstCats as $firstCat) {
            $lastNews = $this->category->getLastNewsByCategory($firstCat->id);
            $firstCat->lastNews = $lastNews;
        }
        $listNewsRE = $this->newsRealEstale->getLastNewsRealEstale(6);

        // news show homepage
        $newsHome = null;
        $listNewsHome = NewsHome::orderBy('order', 'ASC')->where('show_type', 1)->take(5)->offset(0)->get();
        foreach ($listNewsHome as $nh) {
            $nh->news_title = $nh->getNews->news_title;
            $nh->news_content = $nh->getNews->news_content;
            $nh->news_sapo = $nh->getNews->news_sapo;
            $nh->slug = $nh->getNews->slug;
            $nh->news_image = $nh->getNews->news_image;
        }
        if ($listNewsHome->count() >= 2) {
            $newsHome = $listNewsHome[0];
            $newsHome->hotNews = $listNewsHome[1];
            unset($listNewsHome[0]);
            unset($listNewsHome[1]);
            $newsHome->subList = $listNewsHome;
        }
        
        // News highlight
        $listNewsHL = NewsHighLight::orderBy('order', 'ASC')->where('show_type', 1)->take(4)->offset(0)->get();
        foreach ($listNewsHL as $hl) {
            $hl->news_title = $hl->getNews->news_title;
            $hl->news_content = $hl->getNews->news_content;
            $hl->slug = $hl->getNews->slug;
            $hl->news_image = $hl->getNews->news_image;
        }

        // News lens real estale
        $newsLensRE = null;
        $listNewsLensRE = LensRealEstale::orderBy('order', 'ASC')->where('show_type', 1)->take(3)->offset(0)->get();
        foreach ($listNewsLensRE as $nl) {
            $nl->news_title = $nl->getNews->news_title;
            $nl->news_content = $nl->getNews->news_content;
            $nl->slug = $nl->getNews->slug;
            $nl->news_image = $nl->getNews->news_image;
        }
        if ($listNewsLensRE->count() >= 2) {
            $newsLensRE = $listNewsLensRE[0];
            unset($listNewsLensRE[0]);
            $newsLensRE->subList = $listNewsLensRE;
        }

        // Bài viết dự án nổi bật
        $newsProject = News::where('cat_id', 1016)->take(5)->offset(0)->get();

        return view('frontend/layout/dashboard', compact('languages', 'firstCats', 'sliders', 'listNewsRE', 'newsHome', 'listNewsHL', 'newsLensRE', 'newsProject'));
    }

//    public function newsLetter(Request $request)
//    {
//        $this->validate($request, [
//            'newsletter'                      => 'required|email',
//        ],[
//            'required'                     => "Email không được để trống",
//            'email'                        => "Bạn nhập vào không đúng định dạng email",
//        ]);
//
//        $formData = [
//            'email'             =>$request->get('newsletter'), 
//        ];
//        Mail::send('frontend.maillist.newsletter',$formData, function ($message) {
//            $message->to($this->email);
//        });
//
//        return Redirect()->Route('dashboard');
//    }

    public function setSessionDisplay(Request $request) {
        $data = $request->value;
        if (Session::has('display-layout')) {
            Session::forget('isplay-layout');
        }
        Session::put('display-layout', $data);
        return 'success';
    }

}
