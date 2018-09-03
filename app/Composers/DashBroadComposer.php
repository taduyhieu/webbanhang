<?php

namespace Fully\Composers;

use Product;
use Session;
use Fully\Repositories\Product\ProductInterface;
use Fully\Repositories\ProductCategories\ProductCategoriesInterface;
use Fully\Repositories\News\NewsInterface;
use Fully\Repositories\Slider\SliderInterface;
use Fully\Repositories\Category\CategoryInterface;
use Fully\Repositories\AboutNews\AboutNewsInterface;

/**
 * Class MenuComposer.
 *
 * @author
 */
class DashBroadComposer {

    /**
     * @var \Fully\Repositories\Product\ProductInterface
     */
    protected $product;

    /**
     * DashBroadComposer constructor.
     * @param ProductInterface $products
     */
    public function __construct(ProductInterface $product, ProductCategoriesInterface $productCategories, NewsInterface $news, SliderInterface $slider, CategoryInterface $category, AboutNewsInterface $about_news) {
        $this->product = $product;
        $this->productCategories = $productCategories;
        $this->category = $category;
        $this->about_news = $about_news;
        $this->news = $news;
        $this->slider = $slider;
    }

    /**
     * @param $view
     */
    public function compose($view) {
        //Slide News
        $news = $this->news->all();

        //Slider
        $sliders = $this->slider->all();
        foreach ($sliders as $slider) {
            $product_categories = $this->productCategories->getProCat($slider->product_categories_id);
            $slider->product_categories = $product_categories;
            $categories = $this->category->getCategory($slider->categories_id);
            $about_news = $this->about_news->getAboutNews($slider->categories_id);
            $slider->about_news = $about_news;
        }

        $view->with('sliders', $sliders)->with('news', $news);
    }

}
