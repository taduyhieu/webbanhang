<?php

namespace Fully\Models;
use Fully\Models\Photo;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Fully\Interfaces\ModelInterface as ModelInterface;

/**
 * Class PhotoGallery.
 *
 * @author THC <thanhhaconnection@gmail.com>
 */
class PhotoGallery extends BaseModel implements ModelInterface, SluggableInterface
{
    use SluggableTrait;

    public $table = 'photo_galleries';
    public $fillable = ['title', 'content', 'is_published'];
    protected $appends = ['url'];

    protected $sluggable = array(
        'build_from' => 'title',
        'save_to' => 'slug',
    );

    public function photos()
    {
        return $this->morphMany(Photo::class, 'relationship', 'type');
    }

    public function setUrlAttribute($value)
    {
        $this->attributes['url'] = $value;
    }

    public function getUrlAttribute()
    {
        return 'photo-gallery/'.$this->attributes['slug'];
    }
}
