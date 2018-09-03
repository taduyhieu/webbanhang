<?php

namespace Fully\Models;

use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Fully\Interfaces\ModelInterface as ModelInterface;

/**
 * Class Product.
 *
 * @author THC <thanhhaconnection@gmail.com>
 */
class Contact extends BaseModel implements ModelInterface, SluggableInterface
{
    use SluggableTrait;

    public $table = 'contact';
    public $fillable = ['company_name', 'address', 'phone_number', 'email', 'is_published', 'url_map', 'lang', 'created_at'];
    protected $appends = ['url'];

    protected $sluggable = array(
        'build_from' => 'company_name',
        'save_to' => 'slug',
    );

    public function setUrlAttribute($value)
    {
        $this->attributes['url'] = $value;
    }

    public function getUrlAttribute()
    {
        return getLang().'contact/'.$this->attributes['slug'];
    }
}
