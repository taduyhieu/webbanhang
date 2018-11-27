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
class SaleOff_Product extends Model  {


    public $table = 'saleoff_product';
    public $fillable = ['id', 'id_saleoff', 'id_product'];
    protected $hidden = ['getSaleOff'];

    // public function getCatProduct() {
    //     return $this->belongsTo(Categories::class, 'product_categories_id')->first();
    // }

    // public function getAgencyProduct() {
    //     return $this->belongsTo(Agencies::class, 'agency_product_id')->first();
    // }
    public function getNameSaleOff(){
    	return $this->belongsTo(SaleOfff::class, 'id')->first();
    }
}
