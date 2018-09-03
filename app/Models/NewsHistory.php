<?php

namespace Fully\Models;

use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Illuminate\Database\Eloquent\Model;
use Fully\Models\News;

class NewsHistory extends Model implements SluggableInterface {

    use SluggableTrait;

    public $table = 'news_history';
    public $fillable = ['news_id', 'cat_id', 'news_title', 'slug', 'news_author', 'news_image', 'news_image_note', 'news_sapo', 'news_content', 'news_author', 'news_approver', 'news_status', 'news_publish_date', 'news_is_focus', 'news_mode', 'news_relation', 'news_other_cat', 'is_comment', 'image_video_type', 'news_creater', 'news_publisher', 'image_show_type', 'content_facebook', 'type', 'lang'];

    const CREATED_AT = 'news_create_date';
    const UPDATED_AT = 'news_modified_date';

    protected $sluggable = array(
        'build_from' => 'news_title',
        'save_to' => 'slug',
    );

    public function getNews() {
        return $this->belongsTo(News::class, 'news_id');
    }
    
}
