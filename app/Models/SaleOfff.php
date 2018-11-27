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
class SaleOfff extends Model implements ModelInterface {

    use SluggableTrait;

    public $table = 'saleofff';
    public $fillable = ['id', 'name', 'slug', 'start_date', 'end_date', 'status', 'lang', 'created_at', 'updated_at'];
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


    public function getProduct() {
        return $this->belongsTo(Product::class, 'product_id')->first();
    }

    public function getSaleOff() {
        return $this->belongsTo(Product::class, 'product_id')->get();
    }

}
