<?php

namespace Fully\Models;

use Fully\Models\News;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class Comment extends Model {

    public $table = 'comment';
    public $fillable = ['news_id', 'name', 'email', 'content', 'show_status', 'post_time', 'publish_time'];
    protected $hidden = ['getNews'];

    public function getNews() {
        return $this->belongsTo(News::class, 'news_id');
    }

}
