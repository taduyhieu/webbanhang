<?php

namespace Fully\Models;

use Illuminate\Database\Eloquent\Model;
use Fully\Models\Categories;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Fully\Interfaces\ModelInterface as ModelInterface;

/**
 * Class Categories.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class Categories extends Model implements ModelInterface, SluggableInterface {

    use SluggableTrait;

    public $table = 'categories';
    public $fillable = ['title','cat_parent_id', 'url_link', 'lang', 'status', 'created_at', 'updated_at'];
    protected $hidden = ['getNews', 'getNewsHighLights', 'getNewsCate'];
    protected $appends = ['url'];
    public $timestamps = true;
    protected $sluggable = array(
        'build_from' => 'title',
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

    public function getCatParent() {
        return $this->belongsTo(Categories::class, 'cat_parent_id')->first();
    }

}
