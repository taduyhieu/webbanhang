<?php

namespace Fully\Models;

use Fully\Models\PhotoGallery;
use Fully\Models\NewsRealEstale;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Photo.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class Photo extends Model {

    public $table = 'photos';
    public $timestamps = false;
    protected $hidden = ['photo_gallery', 'getNewsRealEstale'];

    public function photo_gallery() {
        return $this->morphTo(PhotoGallery::class, 'relationship');
    }
    
    public function getNewsRealEstale() {
        return $this->morphTo(NewsRealEstale::class, 'relationship_id');
    }
}
