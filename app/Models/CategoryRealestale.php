<?php

namespace Fully\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Fully\Interfaces\ModelInterface as ModelInterface;

/**
 * Class Video.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class CategoryRealestale extends Model implements ModelInterface, SluggableInterface
{
    use SluggableTrait;

    public $table = 'category_realestale';
    public $fillable = ['name', 'slug', 'parent_id', 'order', 'meta_description', 'meta_keyword', 'status', 'lang'];
    protected $hidden = ['getNewsRealEstale'];
    protected $sluggable = array(
        'build_from' => 'name',
        'save_to' => 'slug',
    );

    public function getDetailsAttribute()
    {
        return $this->attributes['details'];
    }

    public function setDetailsAttribute($value)
    {
        $this->attributes['details'] = $value;
    }

    public function setUrlAttribute($value)
    {
        $this->attributes['url'] = $value;
    }

    public function getUrlAttribute()
    {
        return 'cat_realestale/'.$this->attributes['slug'];
    }

     public function getNewsRealEstale() {
        return $this->hasMany(News::class, 'cat_realestale_id', 'id');
    }
}
