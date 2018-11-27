<?php

namespace Fully\Models;

use Illuminate\Database\Eloquent\Model;
use Fully\Models\Product;
use Fully\Models\Categories;
use Fully\Models\Agencies;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Fully\Interfaces\ModelInterface as ModelInterface;

/**
 * Class Categories.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class Product extends Model implements ModelInterface, SluggableInterface {

    use SluggableTrait;

    public $table = 'product';
    public $fillable = ['id', 'product_name', 'code', 'content', 'slug', 'product_categories_id', 'quatities', 'price', 'color', 'agency_product_id', 'description', 'description_short', 'lang', 'status', 'getSaleOff'];
    protected $hidden = ['getNews', 'getNewsHighLights', 'getNewsCate'];
    protected $appends = ['url'];
    public $timestamps = true;
    protected $sluggable = array(
        'build_from' => 'product_name',
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

    public function getCatProduct() {
        return $this->belongsTo(Categories::class, 'product_categories_id')->first();
    }

    public function getAgencyProduct() {
        return $this->belongsTo(Agencies::class, 'agency_product_id')->first();
    }

    public function getSaleOff(){
        return $this->hasMany(SaleOff_Product::class, 'id_product', 'id');
    }
}
