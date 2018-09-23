<?php

namespace Fully\Repositories\PhotoGallery;

use Fully\Repositories\RepositoryInterface;

/**
 * Interface PhotoGalleryInterface.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
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
