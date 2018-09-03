<?php

namespace Fully\Models;

use Fully\Models\NewsRealEstale;
use Illuminate\Database\Eloquent\Model;

class MetadataRealEstale extends Model {

    public $table = 'metadata_realestale';
    protected $hidden = ['getNews'];
    public $timestamps = false;

    public function getNews() {
        return $this->belongsTo(NewsRealEstale::class, 'news_realestale_id');
    }

}
