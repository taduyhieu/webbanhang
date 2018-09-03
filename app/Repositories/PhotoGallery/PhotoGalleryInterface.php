<?php

namespace Fully\Repositories\PhotoGallery;

use Fully\Repositories\RepositoryInterface;

/**
 * Interface PhotoGalleryInterface.
 *
 * @author THC <thanhhaconnection@gmail.com>
 */
interface PhotoGalleryInterface extends RepositoryInterface
{
    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getBySlug($slug);
}
