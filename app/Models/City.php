<?php

namespace Fully\Models;

use Fully\Models\District;
use Fully\Models\NewsRealEstale;
use Fully\Models\TagNewsRealEstale;
use Illuminate\Database\Eloquent\Model;

class City extends Model {

    public $table = 'city';
    protected $hidden = ['getDistrict', 'getNewsRealEstaleByCity'];

    public function getDistrict() {
        return $this->hasMany(District::class, 'city_id', 'id');
    }

    public function getNewsRealEstaleByCity() {
        return $this->hasMany(NewsRealEstale::class, 'city_id', 'id');
    }

    public function getTagNewsRealEstale() {
        return $this->hasMany(TagNewsRealEstale::class, 'city_id', 'id');
    }

}
