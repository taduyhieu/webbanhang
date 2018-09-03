<?php

namespace Fully\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel.
 *
 * @author THC <thanhhaconnection@gmail.com>
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
