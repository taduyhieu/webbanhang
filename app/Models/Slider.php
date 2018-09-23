<?php

namespace Fully\Models;
use Fully\Models\Photo;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Slider.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class Slider extends Model
{
    public $table = 'sliders';

    public function images()
    {
        return $this->morphMany(Photo::class, 'relationship', 'type');
    }
}
