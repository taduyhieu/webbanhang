<?php

namespace Fully\Models;

use Illuminate\Database\Eloquent\Model;
use Fully\Models\News;
use Fully\Models\NewsHighLight;
use Fully\Models\NewsCate;
use Fully\Models\Category;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Fully\Interfaces\ModelInterface as ModelInterface;

/**
 * Class Category.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class Category extends Model implements ModelInterface, SluggableInterface {

    use SluggableTrait;

    public $table = 'category';
    public $fillable = ['name', 'order', 'cat_parent_id'];
    protected $hidden = ['getNews', 'getNewsHighLights', 'getNewsCate'];
    protected $appends = ['url'];
    public $timestamps = false;
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

    public function getNews() {
        return $this->hasMany(News::class, 'cat_id', 'id');
    }

    public function hasChildItems($id) {
        $count = $this->where('cat_parent_id', $id)->where('lang', getLang())->get()->count();
        if ($count === 0) {
            return false;
        }

        return true;
    }

    public function getNewsHighLights() {
        return $this->hasMany(NewsHighLight::class, 'cat_id', 'id');
    }

    public function getNewsCate() {
        return $this->hasMany(NewsCate::class, 'cat_id', 'id');
    }

    public function getCatParent() {
        return $this->belongsTo(Category::class, 'cat_parent_id');
    }

}
