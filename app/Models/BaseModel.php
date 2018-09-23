<?php

namespace Fully\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class BaseModel extends Model
{
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($query) use ($search) {

            $query->where('title', 'LIKE', "%$search%")
                    ->where('lang', getLang())
                    ->orWhere('content', 'LIKE', "%$search%");
        });
    }
}
