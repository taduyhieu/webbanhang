<?php

namespace Fully\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Setting.
 *
 * @author THC <thanhhaconnection@gmail.com>
 */
class Setting extends Model
{
    public $table = 'settings';
    public $fillable = ['settings', 'lang'];
}
