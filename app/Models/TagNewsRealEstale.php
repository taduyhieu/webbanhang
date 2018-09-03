<?php

namespace Fully\Models;

use Fully\Models\TagRealEstale;
use Fully\Models\NewsRealEstale;
use Fully\Models\City;
use Illuminate\Database\Eloquent\Model;

class TagNewsRealEstale extends Model {

    public $table = 'tagnews_realestale';
    protected $hidden = ['getNewsRealEstale', 'getTagRealEstale'];
    public $timestamps = false;

    public function getNewsRealEstale() {
        return $this->belongsTo(NewsRealEstale::class, 'news_realestale_id');
    }

    public function getTagRealEstale() {
        return $this->belongsTo(TagRealEstale::class, 'tag_realestale_id');
    }
    
    public function getCity() {
        return $this->belongsTo(City::class, 'city_id');
    }

}
