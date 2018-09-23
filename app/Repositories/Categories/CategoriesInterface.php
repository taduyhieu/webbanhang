<?php

namespace Fully\Repositories\Categories;

use Fully\Repositories\RepositoryInterface;

/**
 * Interface CategoryInterface.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
interface CategoriesInterface extends RepositoryInterface {

    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getBySlug($slug);
}
