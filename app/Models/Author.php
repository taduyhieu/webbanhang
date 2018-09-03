<?php

namespace Fully\Models;

use Fully\Models\User;
use Illuminate\Database\Eloquent\Model;

class Author extends Model {

    public $table = 'author';
    protected $fillable = ['name', 'user_id', 'status'];
    public $timestamps = false;

    public function getUser() {
        return $this->belongsTo(User::class, 'user_id');
    }

}
