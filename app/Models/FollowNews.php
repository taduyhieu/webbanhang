<?php

namespace Fully\Models;

use Fully\Models\News;
use Fully\Models\Category;
use Illuminate\Database\Eloquent\Model;

class FollowNews extends Model {

    public $table = 'follow_news';
    protected $fillable = ['news_id', 'cat_id', 'order'];
    protected $hidden = ['getNews', 'getCategory'];

    public function getNews() {
        return $this->belongsTo(News::class, 'news_id');
    }

    public function getCategory() {
        return $this->belongsTo(Category::class, 'cat_id');
    }

}
