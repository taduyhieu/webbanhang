<?php

namespace Fully\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Setting.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class Setting extends Model
{
    public $table = 'settings';
    public $fillable = ['settings', 'lang'];
}
