<?php

namespace Fully\Models;

use Fully\Models\TagNewsRealEstale;
use Fully\Models\TagRealEstale;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Fully\Interfaces\ModelInterface as ModelInterface;

class TagRealEstale extends Model implements ModelInterface, SluggableInterface {

    use SluggableTrait;

    public $table = 'tag_realestale';
    public $fillable = ['name', 'tag_parent_id'];
    protected $hidden = ['getTagNewsRealEstales', 'getTagParent', 'getTagChild'];
    protected $appends = ['url'];
    
    protected $sluggable = array(
        'build_from' => 'name',
        'save_to' => 'slug',
    );
    public function setUrlAttribute($value) {
        $this->attributes['url'] = $value;
    }

    public function getUrlAttribute() {
        return getLang() . '/realestale-tag/' . $this->attributes['slug'];
    }

    public function getTagNewsRealEstales() {
        return $this->hasMany(TagNewsRealEstale::class, 'tag_realestale_id', 'id');
    }
    
    public function getTagParent() {
        return $this->belongsTo(TagRealEstale::class, 'tag_parent_id');
    }
    
    public function getTagChild() {
        return $this->hasMany(TagRealEstale::class, 'tag_parent_id', 'id');
    }
}
