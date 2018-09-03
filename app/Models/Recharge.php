<?php

namespace Fully\Models;

use Fully\Models\User;
use Illuminate\Database\Eloquent\Model;
use Fully\Interfaces\ModelInterface as ModelInterface;

class Recharge extends Model implements ModelInterface {

    public $table = 'recharge';
    public $fillable = ['user_id', 'recharge_method', 'seri_number', 'card_number', 'bank_number', 'cost'];
    protected $hidden = ['getUser'];
    protected $appends = ['url'];

    public function getUrlAttribute() {
        
    }

    public function setUrlAttribute($value) {
        
    }

    public function getUser() {
        return $this->hasMany(User::class, 'user_id');
    }

}
