<?php

namespace Fully\Providers;

use Illuminate\Support\ServiceProvider;
use Fully\Models\Category;
use Fully\Models\Categories;
use Fully\Models\Agencies;
use Fully\Models\News;
use Fully\Models\NewsRealEstale;
use Fully\Models\PhotoGallery;
use Fully\Models\Product;
use Fully\Models\SaleOff;
use Fully\Models\SaleOfff;
use Fully\Models\Tag;
use Fully\Models\Video;
use Fully\Models\Menu;
use Fully\Models\Slider;
use Fully\Models\Setting;
use Fully\Models\Contact;
use Fully\Models\Banner;
use Fully\Models\Author;
use Fully\Models\TagNewsRealEstale;
use Fully\Models\CategoryRealestale;
use Fully\Models\TagRealEstale;
use Fully\Models\Comment;
use Fully\Models\Survey;
use Fully\Repositories\Author\AuthorRepository;
use Fully\Repositories\Author\CacheDecorator as AuthorCacheDecorator;
use Fully\Repositories\Categories\CategoriesRepository;
use Fully\Repositories\Categories\CacheDecorator as CategoriesCacheDecorator;
use Fully\Repositories\Category\CategoryRepository;
use Fully\Repositories\Category\CacheDecorator as CategoryCacheDecorator;
use Fully\Repositories\CategoryRealestale\CategoryRealestaleRepository;
use Fully\Repositories\CategoryRealestale\CacheDecorator as CategoryRealestaleCacheDecorator;
use Fully\Repositories\Banner\BannerRepository;
use Fully\Repositories\Banner\CacheDecorator as BannerCacheDecorator;

use Fully\Repositories\Comment\CommentRepository;
use Fully\Repositories\Comment\CacheDecorator as CommentCacheDecorator;

use Fully\Repositories\Product\ProductRepository;
use Fully\Repositories\Product\CacheDecorator as ProductCacheDecorator;

use Fully\Repositories\SaleOff\SaleOffRepository;
use Fully\Repositories\SaleOff\CacheDecorator as SaleOffCacheDecorator;

use Fully\Repositories\SaleOfff\SaleOfffRepository;
use Fully\Repositories\SaleOfff\CacheDecorator as SaleOfffCacheDecorator;

use Fully\Repositories\Agencies\AgenciesRepository;
use Fully\Repositories\Agencies\CacheDecorator as AgenciesCacheDecorator;

use Fully\Repositories\TagRealEstale\TagRealEstaleRepository;
use Fully\Repositories\TagRealEstale\CacheDecorator as TagRealEstaleCacheDecorator;
use Fully\Repositories\News\NewsRepository;
use Fully\Repositories\News\CacheDecorator as NewsCacheDecorator;
use Fully\Repositories\NewsRealEstale\NewsRealEstaleRepository;
use Fully\Repositories\NewsRealEstale\CacheDecorator as NewsRealEstaleCacheDecorator;
use Fully\Repositories\PhotoGallery\PhotoGalleryRepository;
use Fully\Repositories\PhotoGallery\CacheDecorator as PhotoGalleryCacheDecorator;
use Fully\Repositories\Video\VideoRepository;
use Fully\Repositories\Video\CacheDecorator as VideoCacheDecorator;
use Fully\Repositories\Menu\MenuRepository;
use Fully\Repositories\Menu\CacheDecorator as MenuCacheDecorator;
use Fully\Repositories\Slider\SliderRepository;
use Fully\Repositories\Slider\CacheDecorator as SliderCacheDecorator;
use Fully\Repositories\Tag\TagRepository;
use Fully\Repositories\Tag\CacheDecorator as TagCacheDecorator;
use Fully\Repositories\Setting\SettingRepository;
use Fully\Repositories\Survey\SurveyRepository;
use Fully\Repositories\Survey\CacheDecorator as SurveyCacheDecorator;
use Fully\Repositories\Setting\CacheDecorator as SettingCacheDecorator;
use Fully\Repositories\Contact\ContactRepository;
use Fully\Repositories\Contact\CacheDecorator as ContactCacheDecorator;
use Fully\Services\Cache\FullyCache;

/**
 * Class RepositoryServiceProvider.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $app = $this->app;

        //dd($app['config']->get('fully.cache'));

        // author
        $app->bind('Fully\Repositories\Author\AuthorInterface', function ($app) {

            $author = new AuthorRepository(
                new Author()
            );

            if ($app['config']->get('fully.cache') === true && $app['config']->get('is_admin', false) == false) {
                $author = new AuthorCacheDecorator(
                    $author,
                    new FullyCache($app['cache'], 'author')
                );
            }

            return $author;
        });    
        
        // category
        $app->bind('Fully\Repositories\Category\CategoryInterface', function ($app) {

            $category = new CategoryRepository(
                new Category()
            );

            if ($app['config']->get('fully.cache') === true && $app['config']->get('is_admin', false) == false) {
                $category = new CategoryCacheDecorator(
                    $category,
                    new FullyCache($app['cache'], 'categories')
                );
            }

            return $category;
        });

        // categories
        $app->bind('Fully\Repositories\Categories\CategoriesInterface', function ($app) {

            $category = new CategoriesRepository(
                new Categories()
            );

            if ($app['config']->get('fully.cache') === true && $app['config']->get('is_admin', false) == false) {
                $category = new CategoriesCacheDecorator(
                    $category,
                    new FullyCache($app['cache'], 'categories')
                );
            }

            return $category;
        });

        // comment
        $app->bind('Fully\Repositories\Comment\CommentInterface', function ($app) {

            $comment = new CommentRepository(
                new Comment()
            );

            if ($app['config']->get('fully.cache') === true && $app['config']->get('is_admin', false) == false) {
                $comment = new CommentCacheDecorator(
                    $comment,
                    new FullyCache($app['cache'], 'comment')
                );
            }

            return $comment;
        });

        // category_realestale
        $app->bind('Fully\Repositories\CategoryRealestale\CategoryRealestaleInterface', function ($app) {

            $categoryrealestale = new CategoryRealestaleRepository(
                new CategoryRealestale()
            );

            if ($app['config']->get('fully.cache') === true && $app['config']->get('is_admin', false) == false) {
                $categoryrealestale = new CategoryRealestaleCacheDecorator(
                    $categoryrealestale,
                    new FullyCache($app['cache'], 'categoryrealestale')
                );
            }

            return $categoryrealestale;
        });

        // news
        $app->bind('Fully\Repositories\News\NewsInterface', function ($app) {

            $news = new NewsRepository(
                new News()
            );

            if ($app['config']->get('fully.cache') === true && $app['config']->get('is_admin', false) == false) {
                $news = new NewsCacheDecorator(
                    $news,
                    new FullyCache($app['cache'], 'news')
                );
            }

            return $news;
        });

        // product
        $app->bind('Fully\Repositories\Product\ProductInterface', function ($app) {

            $product = new ProductRepository(
                new Product()
            );

            if ($app['config']->get('fully.cache') === true && $app['config']->get('is_admin', false) == false) {
                $product = new ProductCacheDecorator(
                    $product,
                    new FullyCache($app['cache'], 'product')
                );
            }

            return $product;
        });

        // agency
        $app->bind('Fully\Repositories\Agencies\AgenciesInterface', function ($app) {

            $agency = new AgenciesRepository(
                new Agencies()
            );

            if ($app['config']->get('fully.cache') === true && $app['config']->get('is_admin', false) == false) {
                $agency = new AgenciesCacheDecorator(
                    $agency,
                    new FullyCache($app['cache'], 'agency')
                );
            }

            return $agency;
        });

        // sale-off
        $app->bind('Fully\Repositories\SaleOff\SaleOffInterface', function ($app) {

            $saleoff = new SaleOffRepository(
                new SaleOff()
            );

            if ($app['config']->get('fully.cache') === true && $app['config']->get('is_admin', false) == false) {
                $saleoff = new SaleOffCacheDecorator(
                    $saleoff,
                    new FullyCache($app['cache'], 'saleoff')
                );
            }

            return $saleoff;
        });

        // sale-offf
        $app->bind('Fully\Repositories\SaleOfff\SaleOfffInterface', function ($app) {

            $saleofff = new SaleOfffRepository(
                new SaleOfff()
            );

            if ($app['config']->get('fully.cache') === true && $app['config']->get('is_admin', false) == false) {
                $saleofff = new SaleOfffCacheDecorator(
                    $saleofff,
                    new FullyCache($app['cache'], 'saleofff')
                );
            }

            return $saleofff;
        });


        
        // news real estale
        $app->bind('Fully\Repositories\NewsRealEstale\NewsRealEstaleInterface', function ($app) {

            $newsRealEstale = new NewsRealEstaleRepository(
                new NewsRealEstale()
            );

            if ($app['config']->get('fully.cache') === true && $app['config']->get('is_admin', false) == false) {
                $ewsRealEstale = new NewsRealEstaleCacheDecorator(
                    $newsRealEstale,
                    new FullyCache($app['cache'], '$newsRealEstale')
                );
            }
            
            return $newsRealEstale;
        });

        // photo gallery
        $app->bind('Fully\Repositories\PhotoGallery\PhotoGalleryInterface', function ($app) {

            $photoGallery = new PhotoGalleryRepository(
                new PhotoGallery()
            );

            if ($app['config']->get('fully.cache') === true && $app['config']->get('is_admin', false) == false) {
                $photoGallery = new PhotoGalleryCacheDecorator(
                    $photoGallery,
                    new FullyCache($app['cache'], 'photo_galleries')
                );
            }

            return $photoGallery;
        });

        // tag
        $app->bind('Fully\Repositories\Tag\TagInterface', function ($app) {

            $tag = new TagRepository(
                new Tag()
            );

            if ($app['config']->get('fully.cache') === true && $app['config']->get('is_admin', false) == false) {
                $tag = new TagCacheDecorator(
                    $tag,
                    new FullyCache($app['cache'], 'pages')
                );
            }

            return $tag;
        });


        // tag_real_estale
        $app->bind('Fully\Repositories\TagRealEstale\TagRealEstaleInterface', function ($app) {

            $tagRealEstale = new TagRealEstaleRepository(
                new TagRealEstale()
            );

            if ($app['config']->get('fully.cache') === true && $app['config']->get('is_admin', false) == false) {
                $tagRealEstale = new TagRealEstaleCacheDecorator(
                    $tagRealEstale,
                    new FullyCache($app['cache'], 'pages')
                );
            }

            return $tagRealEstale;
        });
        // video
        $app->bind('Fully\Repositories\Video\VideoInterface', function ($app) {

            $video = new VideoRepository(
                new Video()
            );

            if ($app['config']->get('fully.cache') === true && $app['config']->get('is_admin', false) == false) {
                $video = new VideoCacheDecorator(
                    $video,
                    new FullyCache($app['cache'], 'pages')
                );
            }

            return $video;
        });

        // menu
        $app->bind('Fully\Repositories\Menu\MenuInterface', function ($app) {

            $menu = new MenuRepository(
                new Menu()
            );

            if ($app['config']->get('fully.cache') === true && $app['config']->get('is_admin', false) == false) {
                $menu = new MenuCacheDecorator(
                    $menu,
                    new FullyCache($app['cache'], 'menus')
                );
            }

            return $menu;
        });

        // slider
        $app->bind('Fully\Repositories\Slider\SliderInterface', function ($app) {

            $slider = new SliderRepository(
                new Slider()
            );

            if ($app['config']->get('fully.cache') === true && $app['config']->get('is_admin', false) == false) {
                $slider = new SliderCacheDecorator(
                    $slider,
                    new FullyCache($app['cache'], 'sliders')
                );
            }

            return $slider;
        });

        // banner
        $app->bind('Fully\Repositories\Banner\BannerInterface', function ($app) {

            $banner = new BannerRepository(
                new Banner()
            );

            if ($app['config']->get('fully.cache') === true && $app['config']->get('is_admin', false) == false) {
                $banner = new BannerCacheDecorator(
                    $banner,
                    new FullyCache($app['cache'], 'banners')
                );
            }

            return $banner;
        });
        // setting
        $app->bind('Fully\Repositories\Setting\SettingInterface', function ($app) {

            $setting = new SettingRepository(
                new Setting()
            );

            if ($app['config']->get('fully.cache') === true && $app['config']->get('is_admin', false) == false) {
                $setting = new SettingCacheDecorator(
                    $setting,
                    new FullyCache($app['cache'], 'settings')
                );
            }

            return $setting;
        });

        // contact
        $app->bind('Fully\Repositories\Contact\ContactInterface', function ($app) {

            $contact = new ContactRepository(
                new Contact()
            );
            
            if ($app['config']->get('fully.cache') === true && $app['config']->get('is_admin', false) == false) {
                $contact = new ContactCacheDecorator(
                    $contact,
                    new FullyCache($app['cache'], 'contacts')
                );
            }

            return $contact;
        });
        
        // survey
        $app->bind('Fully\Repositories\Survey\SurveyInterface', function ($app) {

            $survey = new SurveyRepository(
                new Survey()
            );

            if ($app['config']->get('fully.cache') === true && $app['config']->get('is_admin', false) == false) {
                $survey = new SurveyCacheDecorator(
                    $survey,
                    new FullyCache($app['cache'], 'survey')
                );
            }

            return $survey;
        });
    }
}
    