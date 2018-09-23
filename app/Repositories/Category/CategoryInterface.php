<?php

namespace Fully\Repositories\Category;

use Fully\Repositories\RepositoryInterface;

/**
 * Interface CategoryInterface.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
interface CategoryInterface extends RepositoryInterface {

    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getBySlug($slug);
}
