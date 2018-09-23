<?php

namespace Fully\Models;

use Fully\Models\Author;
use Fully\Models\Payment;
use Fully\Models\Recharge;
use Cartalyst\Sentinel\Users\EloquentUser;

/**
 * Class User.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class User extends EloquentUser {

    protected $hidden = ['getAuthor', 'getPayments', 'getRecharges'];

    public function getAuthor() {
        return $this->hasOne(Author::class, 'user_id', 'id');
    }

    public function getPayments() {
        return $this->hasMany(Payment::class, 'user_id', 'id');
    }

    public function getRecharges() {
        return $this->hasMany(Recharge::class, 'user_id', 'id');
    }

}
