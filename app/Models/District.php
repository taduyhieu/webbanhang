<?php

namespace Fully\Models;

use Fully\Models\City;
use Fully\Models\NewsRealEstale;
use Illuminate\Database\Eloquent\Model;

class District extends Model {

    public $table = 'district';
    protected $hidden = ['getCity', 'getNewsRealEstaleByDistrict'];

    public function getCity() {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function getNewsRealEstaleByDistrict() {
        return $this->hasMany(NewsRealEstale::class, 'district_id', 'id');
    }
    
}
