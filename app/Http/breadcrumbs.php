<?php

Breadcrumbs::register('home', function ($breadcrumbs) {

    $breadcrumbs->push('Trang chủ', route('dashboard'));
});

Breadcrumbs::register('blog', function ($breadcrumbs) {

    $breadcrumbs->parent('home');
    $breadcrumbs->push('Blog', route('dashboard.article'));
});

Breadcrumbs::register('blog.post.show', function ($breadcrumbs, $article) {

    $breadcrumbs->parent('blog');
    $breadcrumbs->push($article->title, route('dashboard.article.show', array($article->id, $article->slug)));
});

Breadcrumbs::register('page.show', function ($breadcrumbs, $page) {

    $breadcrumbs->parent('home');
    $breadcrumbs->push($page->title, route('dashboard.page.show', $page->id));
});

Breadcrumbs::register('contact', function ($breadcrumbs) {

    $breadcrumbs->parent('home');
    $breadcrumbs->push('Liên hệ', route('dashboard.contact'));
});

Breadcrumbs::register('news', function ($breadcrumbs) {

    $breadcrumbs->parent('home');
    $breadcrumbs->push('Tin tức', route('dashboard.news'));
});

Breadcrumbs::register('news.show', function ($breadcrumbs, $news) {

    $breadcrumbs->parent('news');
    $breadcrumbs->push($news->title, route('dashboard.news.show', array($news->id, $news->slug)));
});

Breadcrumbs::register('photo_gallery.show', function ($breadcrumbs, $photo_gallery) {

    $breadcrumbs->parent('home');
    $breadcrumbs->push($photo_gallery->title, route('dashboard.photo_gallery.show', array($photo_gallery->id, $photo_gallery->slug)));
});

Breadcrumbs::register('video', function ($breadcrumbs) {

    $breadcrumbs->parent('home');
    $breadcrumbs->push('Video', route('dashboard.video'));
});

Breadcrumbs::register('video.show', function ($breadcrumbs, $video) {

    $breadcrumbs->parent('video');
    $breadcrumbs->push($video->title, route('dashboard.video.show', $video->id));
});

Breadcrumbs::register('project', function ($breadcrumbs) {

    $breadcrumbs->parent('home');
    $breadcrumbs->push('Project', route('dashboard.project'));
});

Breadcrumbs::register('project.show', function ($breadcrumbs, $project) {

    $breadcrumbs->parent('project');
    $breadcrumbs->push($project->title, route('dashboard.project.show', $project->id));
});

// ==================  Start Products =======================//
Breadcrumbs::register('products', function ($breadcrumbs) {

    $breadcrumbs->parent('home');
    $breadcrumbs->push('Sản phẩm', route('dashboard.product.view'));
});
Breadcrumbs::register('product_show', function ($breadcrumbs, $product_category) {

    $breadcrumbs->parent('products');
    $breadcrumbs->push($product_category->title, route('dashboard.product_show', $product_category->title));
});
Breadcrumbs::register('product_child', function ($breadcrumbs, $products) {

    $breadcrumbs->parent('product_show');
    $breadcrumbs->push($products->title, route('dashboard.product_child', $products->title));
});
Breadcrumbs::register('product_child_show', function ($breadcrumbs, $products) {

    $breadcrumbs->parent('product_child');
    $breadcrumbs->push($products->title, route('dashboard.product_child_show', $products->title));
});
Breadcrumbs::register('product_detail', function ($breadcrumbs, $products) {

    $breadcrumbs->parent('product_child_show');
    $breadcrumbs->push($products->title, route('dashboard.product_detail', $products->title));
});
// ==================  End Products =======================//
