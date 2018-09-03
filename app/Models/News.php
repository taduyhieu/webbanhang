<?php

namespace Fully\Models;

use Fully\Models\Category;
use Fully\Models\User;
use Fully\Models\TagNews;
use Fully\Models\NewsHistory;
use Fully\Models\Comment;
use Fully\Models\NewsHome;
use Fully\Models\NewsHighLight;
use Fully\Models\NewsCate;
use Fully\Models\LensRealEstale;
use Fully\Models\FollowNews;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Fully\Interfaces\ModelInterface as ModelInterface;

/**
 * Class News.
 *
 * @author THC <thanhhaconnection@gmail.com>
 */
class News extends BaseModel implements ModelInterface, SluggableInterface {

    use SluggableTrait;

    public $table = 'news';
    public $fillable = ['news_id', 'cat_id', 'news_title', 'news_author', 'news_sapo', 'news_content', 'news_is_focus', 'news_status', 'news_relation','type'];
    protected $appends = ['url'];
    protected $hidden = ['getTagNews', 'getCategory', 'getUserCreater', 'getComments', 'getMetaData','getNewsHistory', 'getNewsHome', 'getNewsHighLights', 'getNewsCate', 'getNewsLensRE', 'getFollowNews'];
    public $primaryKey = 'news_id';
    public $incrementing = false;

    const CREATED_AT = 'news_create_date';
    const UPDATED_AT = 'news_modified_date';

    protected $sluggable = array(
        'build_from' => 'news_title',
        'save_to' => 'slug',
    );
    
    public function getCategory() {
        return $this->belongsTo(Category::class, 'cat_id');
    }

    public function getUserCreater() {
        return $this->belongsTo(User::class, 'news_creater');
    }

    public function getTagNews() {
        return $this->hasMany(TagNews::class, 'news_id', 'news_id');
    }

    public function getMetaData() {
        return $this->hasOne(Metadata::class, 'news_id', 'news_id');
    }

    public function getNewsHistory() {
        return $this->hasMany(NewsHistory::class, 'news_id', 'news_id');
    }

    public function setUrlAttribute($value) {
        $this->attributes['url'] = $value;
    }

    public function getUrlAttribute() {
        return getLang() . '/news/' . $this->attributes['slug'];
    }

    public function getComments() {
        return $this->hasMany(Comment::class, 'news_id', 'news_id');
    }

    public function getNewsHome() {
        return $this->hasOne(NewsHome::class, 'news_id', 'news_id');
    }

    public function getNewsHighLights() {
        return $this->hasOne(NewsHighLight::class, 'news_id', 'news_id');
    }
    
    public function getNewsCate() {
        return $this->hasOne(NewsCate::class, 'news_id', 'news_id');
    }
    
    public function getNewsLensRE() {
        return $this->hasOne(LensRealEstale::class, 'news_id', 'news_id');
    }
    
    public function getFollowNews() {
        return $this->hasOne(FollowNews::class, 'news_id', 'news_id');
    }
}
