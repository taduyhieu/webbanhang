<?php

namespace Fully\Models;
use Fully\Models\News;
use Illuminate\Database\Eloquent\Model;

class NewsHome extends Model {
    public $table = 'newshome';
    protected $fillable = ['news_id', 'order', 'show_type'];
    protected $hidden = ['getNews'];
    public $timestamps = false;
    
    public function getNews() {
        return $this->belongsTo(News::class, 'news_id');
    }
}
