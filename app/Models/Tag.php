<?php

namespace Fully\Models;
use Fully\Models\TagNews;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Fully\Interfaces\ModelInterface as ModelInterface;

class Tag extends Model implements ModelInterface, SluggableInterface
{
    use SluggableTrait;
    public $table = 'tag';
    public $fillable = ['name'];
    protected $hidden = ['getTagNews'];
    protected $appends = ['url'];
    protected $sluggable = array(
        'build_from' => 'name',
        'save_to' => 'slug',
    );
    public function setUrlAttribute($value) {
        $this->attributes['url'] = $value;
    }

    public function getUrlAttribute() {
        return getLang() . '/news-tag/' . $this->attributes['slug'];
    }
    
    public function getTagNews(){
        return $this->hasMany(TagNews::class, 'tag_id', 'id');
    }
    
}
