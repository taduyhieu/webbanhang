<?php

namespace Fully\Providers;

use View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider {

    /**
     * Register bindings in the container.
     */
    public function boot() {
        // Frontend
        View::composer('frontend.layout.menu', 'Fully\Composers\MenuComposer');
        View::composer('frontend.layout.dashboard', 'Fully\Composers\CategoryComposer');
        View::composer('frontend.layout.dashboard', 'Fully\Composers\BannerComposer');
        View::composer('frontend.layout.menu', 'Fully\Composers\BannerComposer');
        View::composer('frontend.side_bars.search-bar', 'Fully\Composers\SearchNewsREComposer');
        View::composer('frontend.side_bars.reads', 'Fully\Composers\ReadsNewsComposer');
        View::composer('frontend.side_bars.video', 'Fully\Composers\VideoComposer');
        View::composer('frontend.side_bars.banner-postion-2', 'Fully\Composers\BannerComposer');
        View::composer('frontend.side_bars.banner-postion-3', 'Fully\Composers\BannerComposer');
        View::composer('frontend.side_bars.banner-postion-4', 'Fully\Composers\BannerComposer');
        View::composer('frontend.side_bars.survey', 'Fully\Composers\SurveyComposer');
        View::composer('frontend.side_bars.follow-news', 'Fully\Composers\NewsComposer');
        View::composer('frontend.side_bars.conversation', 'Fully\Composers\NewsComposer');
        View::composer('frontend.side_bars.reporting', 'Fully\Composers\ReportingComposer');
        View::composer('frontend.news.show', 'Fully\Composers\VideoComposer');

//        View::composer('frontend.layout.layout', 'Fully\Composers\SettingComposer');
//        View::composer('frontend.layout.sidebar_product', 'Fully\Composers\DashBroadComposer');
//        View::composer('frontend.layout.dashboard', 'Fully\Composers\DashBroadComposer');
//        View::composer('frontend.layout.slider', 'Fully\Composers\DashBroadComposer');
//        View::composer('frontend.layout.about-sidebar', 'Fully\Composers\CategoryComposer');
        // Backend
        View::composer('backend/layout/layout', 'Fully\Composers\Admin\MenuComposer');
    }

    /**
     * Register.
     */
    public function register() {
        
    }

}
