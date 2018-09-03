<?php

namespace Fully\Models;
use Fully\Models\News;
use Illuminate\Database\Eloquent\Model;

class Metadata extends Model {
    public $table = 'metadata';
    protected $hidden = ['getNews'];
    public $timestamps = false;
    
    public function getNews() {
        return $this->belongsTo(News::class, 'news_id');
    }
}
