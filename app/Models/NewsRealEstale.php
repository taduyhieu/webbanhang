<?php

namespace Fully\Models;

use Fully\Models\CategoryRealestale;
use Fully\Models\MetadataRealEstale;
use Fully\Models\TagNewsRealEstale;
use Fully\Models\Payment;
use Fully\Models\District;
use Fully\Models\Photo;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Fully\Interfaces\ModelInterface as ModelInterface;
use Illuminate\Database\Eloquent\Model;

class NewsRealEstale extends Model implements ModelInterface, SluggableInterface {

    use SluggableTrait;

    public $table = 'news_realestale';
    public $fillable = ['cat_realestale_id', 'news_title', 'news_content', 'type_vip', 'price_all', 'price_m2', 'total_area', 'number_floor', 'number_bedroom', 'number_bathroom', 'feature', 'direction', 'project', 'utilities', 'environment', 'legal_state', 'place', 'news_status', 'type', 'length', 'width', 'dining_room', 'kitchen', 'mobile', 'car_place', 'owner', 'terrace', 'city_id', 'district_id', 'type'];
    protected $appends = ['url'];
    protected $hidden = ['getCategoryRealestale', 'getMetadataRealEstale', 'getTagNewsRealEstales', 'getPayments','getDistrict', 'getPhotos'];

    const CREATED_AT = 'news_create_date';
    const UPDATED_AT = 'news_modified_date';

    protected $sluggable = array(
        'build_from' => 'news_title',
        'save_to' => 'slug',
    );

    public function getUrlAttribute() {
        return 'san-giao-dich/'.$this->attributes['slug'];
    }

    public function setUrlAttribute($value) {
        $this->attributes['url'] = $value;
    }

    public function getCategoryRealestale() {
        return $this->belongsTo(CategoryRealestale::class, 'cat_realestale_id');
    }

    public function getMetadataRealEstale() {
        return $this->hasOne(MetadataRealEstale::class, 'news_realestale_id', 'id');
    }

    public function getTagNewsRealEstales() {
        return $this->hasMany(TagNewsRealEstale::class, 'news_realestale_id', 'id');
    }

    public function getPayments() {
        return $this->hasOne(Payment::class, 'news_realestale_id', 'id');
    }
    
    public function getDistrict() {
        return $this->belongsTo(District::class, 'district_id');
    }
    
    public function getPhotos()
    {
        return $this->morphMany(Photo::class, 'relationship', 'type');
    }
}
