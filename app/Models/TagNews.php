<?php

namespace Fully\Models;

use Fully\Models\Tag;
use Fully\Models\News;
use Illuminate\Database\Eloquent\Model;

class TagNews extends Model {

    public $table = 'tagnews';
    protected $hidden = ['getNews', 'getTag'];
    public $timestamps = false;

    public function getNews() {
        return $this->belongsTo(News::class, 'news_id');
    }

    public function getTag() {
        return $this->belongsTo(Tag::class, 'tag_id');
    }

}
