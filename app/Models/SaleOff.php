<?php

namespace Fully\Models;

use Illuminate\Database\Eloquent\Model;
use Fully\Models\SaleOff;
use Fully\Models\Categories;
use Fully\Models\Agencies;
use Fully\Models\Product;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Fully\Interfaces\ModelInterface as ModelInterface;

/**
 * Class Categories.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class SaleOff extends Model implements ModelInterface {

    use SluggableTrait;

    public $table = 'saleoff';
    public $fillable = ['id', 'name', 'product_id', 'percent_sale_off', 'slug', 'start_date', 'end_date', 'lang', 'status'];
    protected $hidden = ['getNews', 'getNewsHighLights', 'getNewsCate', 'getProduct'];
    protected $appends = ['url'];
    public $timestamps = true;
    protected $sluggable = array(
        'build_from' => 'name',
        'save_to' => 'slug',
    );

    public function setUrlAttribute($value) {
        $this->attributes['url'] = $value;
    }

    public function getUrlAttribute() {
        return 'danh-muc/' . $this->attributes['slug'];
    }

    // public function getNews() {
    //     return $this->hasMany(News::class, 'cat_id', 'id');
    // }

    // public function hasChildItems($id) {
    //     $count = $this->where('cat_parent_id', $id)->where('lang', getLang())->get()->count();
    //     if ($count === 0) {
    //         return false;
    //     }

    //     return true;
    // }

    // public function getNewsHighLights() {
    //     return $this->hasMany(NewsHighLight::class, 'cat_id', 'id');
    // }

    // public function getNewsCate() {
    //     return $this->hasMany(NewsCate::class, 'cat_id', 'id');
    // }

    public function getProduct() {
        return $this->belongsTo(Product::class, 'product_id')->first();
    }

    // public function getAgencyProduct() {
    //     return $this->belongsTo(Agencies::class, 'agency_product_id')->first();
    // }
}
