<?php

namespace Fully\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Banner.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class Banner extends Model {

    // use SluggableTrait;

    public $table = 'banner';
    public $fillable = ['id', 'name', 'avatar', 'url', 'position', 'start_date', 'end_date', 'status', 'path', 'file_name', 'file_size'];

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_at';

}
