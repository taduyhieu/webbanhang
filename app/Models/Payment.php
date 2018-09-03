<?php

namespace Fully\Models;

use Fully\Models\User;
use Fully\Models\NewsRealEstale;
use Illuminate\Database\Eloquent\Model;
use Fully\Interfaces\ModelInterface as ModelInterface;

class Payment extends Model implements ModelInterface {

    public $table = 'payment';
    public $fillable = ['user_id', 'news_realestale_id', 'cost'];
    protected $hidden = ['getUser', 'getNewsRealEstale'];
    protected $appends = ['url'];

    public function getUrlAttribute() {
        
    }

    public function setUrlAttribute($value) {
        
    }

    public function getUser() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getNewsRealEstale() {
        return $this->belongsTo(NewsRealEstale::class, 'news_realestale_id');
    }

}
