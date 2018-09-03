<?php

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

$languages = LaravelLocalization::getSupportedLocales();
foreach ($languages as $language => $values) {
    $supportedLocales[] = $language;
}

$locale = Request::segment(1);
if (in_array($locale, $supportedLocales)) {
    LaravelLocalization::setLocale($locale);
    App::setLocale($locale);
}


Route::get('/', function () {

    return Redirect::to(LaravelLocalization::getCurrentLocale(), 302);
});

Route::group(array('prefix' => LaravelLocalization::getCurrentLocale(), 'before' => array('localization', 'before')), function () {

    Session::put('my.locale', LaravelLocalization::getCurrentLocale());

    // frontend dashboard
    Route::get('/', ['as' => 'dashboard', 'uses' => 'HomeController@index']);
    
    // User
//    Route::resource('/nguoi-dung', 'UserController');
    Route::post('/user/register/store', 'UserRegisterController@store');
    
    //comment
    Route::post('/binh-luan/submit', array('as' => 'dashboard.comment.store', 'uses' => 'CommentController@save'));
    //Newsletter
    Route::post('/news-letter', array('as' => 'dashboard.newsLetter', 
                                         'uses' => 'HomeController@newsLetter'));
    
    // news
    Route::get('/tin-tuc/{slug}', array('as' => 'dashboard.news.show', 'uses' => 'NewsController@show'));
    
    // news real estale
    Route::get('/san-giao-dich', array('as' => 'dashboard.realestale.index', 'uses' => 'NewsRealEstaleController@index'));
    Route::get('/san-giao-dich/{slug}', array('as' => 'dashboard.realestale.show', 'uses' => 'NewsRealEstaleController@show'));
    Route::post('/san-giao-dich/tim-kiem', array('as' => 'dashboard.realestale.search', 'uses' => 'NewsRealEstaleController@search'));
    Route::get('/san-giao-dich/lien-ket/{slug}', array('as' => 'dashboard.realestale.tag', 'uses' => 'NewsRealEstaleController@getTagNewsRE'));

    Route::get('/san-giao-dich/district/listDistrict',  'NewsRealEstaleController@getListDistrict' );
    
    // tags
    Route::get('/tag/{slug}', array('as' => 'dashboard.tag', 'uses' => 'TagController@show'));

    // categories
    Route::get('/danh-muc/{slug}', array('as' => 'dashboard.category', 'uses' => 'CategoryController@index'));

    // contact
    Route::get('/lien-he', array('as' => 'dashboard.contact', 'uses' => 'ContactController@index'));
    Route::get('/lien-he/{slug}', array('as' => 'dashboard.contact.show', 'uses' => 'ContactController@show'));
    
    // photo gallery
    Route::get('/photo-gallery/{slug}', array('as' => 'dashboard.photo_gallery.show',
                                              'uses' => 'PhotoGalleryController@show', ));

    // video
    Route::get('/video', array('as' => 'dashboard.video', 'uses' => 'VideoController@index'));
    Route::get('/video/{slug}', array('as' => 'dashboard.video.show', 'uses' => 'VideoController@show'));
    Route::get('/video/detail/{slug}', array('as' => 'dashboard.video.show-detail', 'uses' => 'VideoController@showDetail'));
    // rss
    Route::get('/rss', array('as' => 'rss', 'uses' => 'RssController@index'));

    // search
    Route::post('/search', ['as' => 'dashboard.search', 'uses' => 'SearchController@index']);
    Route::get('/search', ['as' => 'dashboard.search', 'uses' => 'SearchController@index']);
    // language
    // Route::get('/set-locale/{language}', array('as' => 'language.set', 'uses' => 'LanguageController@setLocale'));

    // maillist
    Route::get('/save-maillist', array('as' => 'frontend.maillist', 'uses' => 'MaillistController@getMaillist'));
    Route::post('/save-maillist', array('as' => 'frontend.maillist.post', 'uses' => 'MaillistController@postMaillist'));
    
    // ajax - survey-vote
    Route::get('survey/{id}/vote', array('as' => 'dashboard.survey.vote',
                                    'uses' => 'SurveyController@addVote', ))->where('id', '[0-9]+');
    // ajax set session mobile -pc
    Route::post('session/setvalue/display', array('as' => 'dashboard.session.setvalue.display',
                                    'uses' => 'HomeController@setSessionDisplay', ));
    
    
});

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
*/

Route::group(array('prefix' => LaravelLocalization::getCurrentLocale()), function () {

    Route::group(array('prefix' => '/admin',
                       'namespace' => 'Admin',
                       'middleware' => ['before', 'sentinel.auth', 'sentinel.permission'] ), function () {

        // admin dashboard
        Route::get('/', array('as' => 'admin.dashboard', 'uses' => 'DashboardController@index'));

        // user
        Route::resource('user', 'UserController');
        Route::get('user/{id}/delete', array('as' => 'admin.user.delete',
                                             'uses' => 'UserController@confirmDestroy', ))->where('id', '[0-9]+');
        Route::get('user/wallet/{id}', array('as' => 'admin.user.wallet',
                                             'uses' => 'UserController@userWallet', ))->where('id', '[0-9]+');
        Route::get('user/wallet/payment-nganluong', array('as' => 'admin.user-payment.wallet',
                                             'uses' => 'UserController@userPaymentNganLuong', ));
        Route::post('user/recharge', array('as' => 'admin.user-recharge.wallet',
                                             'uses' => 'UserController@rechargeNganLuong', ));
        
//        Route::get('user/update-password', array('as' => 'admin.user.update-password',
//                                             'uses' => 'UserController@updatePasswordView', ));
//        Route::post('user/update-password', array('as' => 'admin.user.update-password.post',
//                                             'uses' => 'UserController@updatePassword', ));
        
        // role
        Route::resource('role', 'RoleController');
        Route::get('role/{id}/delete', array('as' => 'admin.role.delete',
                                              'uses' => 'RoleController@confirmDestroy', ))->where('id', '[0-9]+');
        
        // author
        Route::resource('author', 'AuthorController', array('before' => 'hasAccess:author'));
        Route::get('author/{id}/delete', array('as' => 'admin.author.delete',
                                             'uses' => 'AuthorController@confirmDestroy', ))->where('id', '[0-9]+');
        
        // survey
        Route::resource('survey', 'SurveyController', array('before' => 'hasAccess:survey'));
        Route::get('survey/{id}/delete', array('as' => 'admin.survey.delete',
                                             'uses' => 'SurveyController@confirmDestroy', ))->where('id', '[0-9]+');
        Route::get('survey/{search}/search', array('as' => 'admin.survey.search',
                                            'uses' => 'SurveyController@search', ));

        // news
        Route::resource('news', 'NewsController', array('before' => 'hasAccess:news'));
        Route::get('news/{id}/delete', array('as' => 'admin.news.delete',
                                             'uses' => 'NewsController@confirmDestroy', ))->where('id', '[0-9]+');
        Route::get('news/{search}/search', array('as' => 'admin.news.search',
                                            'uses' => 'NewsController@search', ));
        Route::get('news/tag/listTag',  'NewsController@getListTag' );
        Route::get('news/relation/listNewsRelation',  'NewsController@getListNewsRelation' );
        Route::get('news/{id}/comment/listComment', array('as' => 'admin.news.comment.listComment',
                                            'uses' => 'NewsController@showComments', ))->where('id', '[0-9]+');
        Route::get('news/comment/{id}', array('as' => 'admin.news.comment.detail',
                                            'uses' => 'NewsController@showDetailComments', ))->where('id', '[0-9]+');
        Route::get('news/comment/{id}/edit', array('as' => 'admin.news.comment.edit',
                                            'uses' => 'NewsController@editComments', ))->where('id', '[0-9]+');
        Route::post('news/comment/{id}/update', array('as' => 'admin.news.comment.update',
                                            'uses' => 'NewsController@updateComments', ))->where('id', '[0-9]+');
        Route::post('news/comment/{id}/toggle-publish', array('as' => 'admin.news.comment.toggle-publish',
                                            'uses' => 'CommentController@togglePublish', ))->where('id', '[0-9]+');
        Route::get('news/history/{id}', array('as' => 'admin.news.history',
                                            'uses' => 'NewsController@newsHistory', ))->where('id', '[0-9]+');
        
        // news highlight
        Route::resource('news-highlight', 'NewsHighLightController', array('before' => 'hasAccess:news-highlight'));
        Route::get('news-highlight/{search}/search', array('as' => 'admin.news-highlight.search',
                                            'uses' => 'NewsHighLightController@search', ));
        // news home
        Route::resource('news-home', 'NewsHomeController', array('before' => 'hasAccess:news-home'));
        Route::get('news-home/{search}/search', array('as' => 'admin.news-home.search',
                                            'uses' => 'NewsHomeController@search', ));
        
        // news cate
        Route::resource('news-cate', 'NewsCateController', array('before' => 'hasAccess:news-cate'));
        Route::get('news-cate/{search}/search', array('as' => 'admin.news-cate.search',
                                            'uses' => 'NewsCateController@search', ));
        
        // news lens real estale
        Route::resource('news-lens-re', 'LensRealEstaleController', array('before' => 'hasAccess:news-lens-re'));
        Route::get('news-lens-re/{search}/search', array('as' => 'admin.news-lens-re.search',
                                            'uses' => 'LensRealEstaleController@search', ));
        
        // news follow
        Route::resource('news-follow', 'FollowNewsController', array('before' => 'hasAccess:news-follow'));
        Route::get('news-follow/{search}/search', array('as' => 'admin.news-follow.search',
                                            'uses' => 'FollowNewsController@search', ));
        
        // tags
        Route::resource('news-tag', 'TagController', array('before' => 'hasAccess:news-tag'));
        Route::get('news-tag/{id}/delete', array('as' => 'admin.news-tag.delete',
                                             'uses' => 'TagController@confirmDestroy', ))->where('id', '[0-9]+');
        Route::get('news-tag/{search}/search', array('as' => 'admin.news-tag.search',
                                            'uses' => 'TagController@search', ));

        //comments
        Route::resource('news-comment', 'CommentController', array('before' => 'hasAccess:news-comment'));
        Route::get('news-comment/{id}/delete', array('as' => 'admin.news-comment.delete',
                                              'uses' => 'CommentController@confirmDestroy', ))->where('id', '[0-9]+');
        Route::get('news-comment/{search}/search', array('as' => 'admin.news-comment.search',
                                             'uses' => 'CommentController@search', ));

        // category
        Route::resource('category', 'CategoryController', array('before' => 'hasAccess:category'));
        Route::get('category/{id}/delete', array('as' => 'admin.category.delete',
                                                 'uses' => 'CategoryController@confirmDestroy', ))->where('id', '[0-9]+');
        Route::get('category/{search}/search', array('as' => 'admin.category.search',
                                            'uses' => 'CategoryController@search', ));

        // photo gallery
        Route::resource('photo-gallery', 'PhotoGalleryController');
        Route::get('photo-gallery/{id}/delete', array('as' => 'admin.photo-gallery.delete',
                                                      'uses' => 'PhotoGalleryController@confirmDestroy', ))->where('id', '[0-9]+');

        // category-realestale
        Route::resource('realestale-category', 'CategoryRealestaleController', array('before' => 'hasAccess:realestale-category'));
        Route::get('realestale-category/{id}/delete', array('as' => 'admin.realestale-category.delete',
                                             'uses' => 'CategoryRealestaleController@confirmDestroy', ))->where('id', '[0-9]+');
        Route::get('realestale-category/{search}/search', array('as' => 'admin.realestale-category.search',
                                            'uses' => 'CategoryRealestaleController@search', ));
        
        // realestale-tag
        Route::resource('realestale-tag', 'TagRealEstaleController', array('before' => 'hasAccess:realestale-category'));
        Route::get('realestale-tag/{id}/delete', array('as' => 'admin.realestale-tag.delete',
                                             'uses' => 'TagRealEstaleController@confirmDestroy', ))->where('id', '[0-9]+');
        Route::get('realestale-tag/{search}/search', array('as' => 'admin.realestale-tag.search',
                                            'uses' => 'TagRealEstaleController@search', ));
        
        // news-realestale
        Route::resource('realestale-news', 'NewsRealEstaleController', array('before' => 'hasAccess:realestale-news'));
        Route::get('realestale-news/{id}/create', array('as' => 'admin.realestale-news.create-2',
                                             'uses' => 'NewsRealEstaleController@uploadPhotosCreate', ));
        Route::get('realestale-news/{id}/delete', array('as' => 'admin.realestale-news.delete',
                                             'uses' => 'NewsRealEstaleController@confirmDestroy', ))->where('id', '[0-9]+');
        Route::get('realestale-news/{search}/search', array('as' => 'admin.realestale-news.search',
                                            'uses' => 'NewsRealEstaleController@search', ));
        Route::get('realestale-news/tag/listTagRE',  'NewsRealEstaleController@getListTagRealEstale' );
        Route::get('realestale-news/district/listDistrict',  'NewsRealEstaleController@getListDistrictByCity' );
        
        // video
        Route::resource('video', 'VideoController');
        Route::get('video/{id}/delete', array('as' => 'admin.video.delete',
                                              'uses' => 'VideoController@confirmDestroy', ))->where('id', '[0-9]+');
        Route::post('/video/get-video-detail', array('as' => 'admin.video.detail',
                                                     'uses' => 'VideoController@getVideoDetail', ))->where('id', '[0-9]+');
        // file upload video
        Route::patch('/video/{id}', array('as' => 'admin.video.update',
                                                        'uses' => 'VideoController@upload', ))->where('id', '[0-9]+');
        //banner
        Route::resource('banner', 'BannerController');
        Route::get('banner/{id}/delete', array('as' => 'admin.banner.delete',
                                                 'uses' => 'BannerController@confirmDestroy', ))->where('id', '[0-9]+');
        Route::get('banner/{search}/search', array('as' => 'admin.banner.search',
                                            'uses' => 'BannerController@search', ));
        // ajax - banner
        Route::post('banner/{id}/toggle-publish', array('as' => 'admin.banner.toggle-publish',
                                                      'uses' => 'BannerController@togglePublish', ))->where('id', '[0-9]+');
        // contact
        Route::resource('contact', 'ContactController', array('before' => 'hasAccess:contact'));
        Route::get('contact/{id}/delete', array('as' => 'admin.contact.delete',
                                                 'uses' => 'ContactController@confirmDestroy', ))->where('id', '[0-9]+');

        // ajax - contact
        Route::post('contact/{id}/toggle-publish', array('as' => 'admin.contact.toggle-publish',
                                                      'uses' => 'ContactController@togglePublish', ))->where('id', '[0-9]+');

        // ajax - news
        Route::post('news/{id}/toggle-publish', array('as' => 'admin.news.toggle-publish',
                                                      'uses' => 'NewsController@togglePublish', ))->where('id', '[0-9]+');
        
        // ajax - news highlight
        Route::post('news-highlight/{id}/toggle-publish', array('as' => 'admin.news-highlight.toggle-publish',
                                                      'uses' => 'NewsHighLightController@togglePublish', ))->where('id', '[0-9]+');
        
        // ajax - news home
        Route::post('news-home/{id}/toggle-publish', array('as' => 'admin.news-home.toggle-publish',
                                                      'uses' => 'NewsHomeController@togglePublish', ))->where('id', '[0-9]+');
        
        // ajax - news cate
        Route::post('news-cate/{id}/toggle-publish', array('as' => 'admin.news-cate.toggle-publish',
                                                      'uses' => 'NewsCateController@togglePublish', ))->where('id', '[0-9]+');
        
        // ajax - news lens real estale
        Route::post('news-lens-re/{id}/toggle-publish', array('as' => 'admin.news-lens-re.toggle-publish',
                                                      'uses' => 'LensRealEstaleController@togglePublish', ))->where('id', '[0-9]+');
        
        // ajax - news follow
        Route::post('news-follow/{id}/toggle-publish', array('as' => 'admin.news-follow.toggle-publish',
                                                      'uses' => 'FollowNewsController@togglePublish', ))->where('id', '[0-9]+');
        
        // ajax - news show comment home
        Route::post('news-show-comment/{id}/toggle-publish', array('as' => 'admin.news-show-comment.toggle-publish',
                                                      'uses' => 'NewsController@togglePublishComment', ))->where('id', '[0-9]+');
        
        // ajax - comment
        Route::post('comment/{id}/toggle-publish', array('as' => 'admin.comment.toggle-publish',
                                                      'uses' => 'CommentController@togglePublish', ))->where('id', '[0-9]+');

        // ajax - category
        Route::post('category/{id}/toggle-publish', array('as' => 'admin.category.toggle-publish',
                                                      'uses' => 'CategoryController@togglePublish', ))->where('id', '[0-9]+');
        
        // ajax - survey-active
        Route::post('survey/{id}/active', array('as' => 'admin.survey.active',
                                                      'uses' => 'SurveyController@toggleActive', ))->where('id', '[0-9]+');
        
        // ajax - photo gallery
        Route::post('photo-gallery/{id}/toggle-publish', array('as' => 'admin.photo_gallery.toggle-publish',
                                                               'uses' => 'PhotoGalleryController@togglePublish', ))->where('id', '[0-9]+');
        Route::post('photo-gallery/{id}/toggle-menu', array('as' => 'admin.photo_gallery.toggle-menu',
                                                            'uses' => 'PhotoGalleryController@toggleMenu', ))->where('id', '[0-9]+');

        // file upload photo gallery
        Route::post('/photo-gallery/upload/{id}', array('as' => 'admin.photo.gallery.upload.image',
                                                        'uses' => 'PhotoGalleryController@upload', ))->where('id', '[0-9]+');
        Route::post('/photo-gallery-delete-image', array('as' => 'admin.photo.gallery.delete.image',
                                                         'uses' => 'PhotoGalleryController@deleteImage', ));
        
        // file upload photo realestale news
        Route::post('/realestale-news/upload/{id}', array('as' => 'admin.photo.realestale.upload.image',
                                                        'uses' => 'NewsRealEstaleController@upload', ))->where('id', '[0-9]+');
        Route::post('/realestale-news-delete-image', array('as' => 'admin.photo.realestale.delete.image',
                                                         'uses' => 'NewsRealEstaleController@deleteImage', ));
        
        // slider
        Route::get('/slider', array('as' => 'admin.slider',function () {
                return View::make('backend/slider/index');
        }, ));

        // slider
        Route::resource('slider', 'SliderController');
        Route::get('/banner/{slug}', array('as' => 'admin.banner.show', 'uses' => 'SliderController@show'));
        Route::get('slider/{id}/delete', array('as' => 'admin.slider.delete',
                                               'uses' => 'SliderController@confirmDestroy', ))->where('id', '[0-9]+');

        // file upload slider
        Route::post('/slider/upload/{id}', array('as' => 'admin.slider.upload.image',
                                                 'uses' => 'SliderController@upload', ))->where('id', '[0-9]+');
        Route::post('/slider-delete-image', array('as' => 'admin.slider.delete.image',
                                                  'uses' => 'SliderController@deleteImage', ));

        // menu-managment
        Route::resource('menu', 'MenuController');
        Route::post('menu/save', array('as' => 'admin.menu.save', 'uses' => 'MenuController@save'));
        Route::get('menu/{id}/delete', array('as' => 'admin.menu.delete',
                                             'uses' => 'MenuController@confirmDestroy', ))->where('id', '[0-9]+');
        Route::post('menu/{id}/toggle-publish', array('as' => 'admin.menu.toggle-publish',
                                                      'uses' => 'MenuController@togglePublish', ))->where('id', '[0-9]+');

        // log
        Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

        // language
        Route::get('language/set-locale/{language}', array('as' => 'admin.language.set',
                                                           'uses' => 'LanguageController@setLocale', ));
    });
});

// Route::post('/contact', array('as' => 'dashboard.contact.post',
//                               'uses' => 'FormPostController@postContact', ), array('before' => 'csrf'));

// filemanager
Route::get('filemanager/show', function () {

    return View::make('backend/plugins/filemanager');
})->before('sentinel.auth');

// login
Route::get('/admin/login', array(
    'as' => 'admin.login',
    function () {

        return View::make('backend/auth/login');
    }, ));

Route::group(array('namespace' => 'Admin'), function () {

    // admin auth
    Route::get('admin/logout', array('as' => 'admin.logout', 'uses' => 'AuthController@getLogout'));
    Route::get('admin/login', array('as' => 'admin.login', 'uses' => 'AuthController@getLogin'));
    Route::post('admin/login', array('as' => 'admin.login.post', 'uses' => 'AuthController@postLogin'));

    // admin password reminder
    Route::get('admin/forgot-password', array('as' => 'admin.forgot.password',
                                              'uses' => 'AuthController@getForgotPassword', ));
    Route::post('admin/forgot-password', array('as' => 'admin.forgot.password.post',
                                               'uses' => 'AuthController@postForgotPassword', ));

    Route::get('admin/{id}/reset/{code}', array('as' => 'admin.reset.password',
                                                'uses' => 'AuthController@getResetPassword', ))->where('id', '[0-9]+');
    Route::post('admin/reset-password', array('as' => 'admin.reset.password.post',
                                              'uses' => 'AuthController@postResetPassword', ));
});

/*
|--------------------------------------------------------------------------
| General Routes
|--------------------------------------------------------------------------
*/

// error

// 404 page not found
