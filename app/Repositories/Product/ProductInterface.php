<?php

namespace Fully\Repositories\Product;

use Fully\Repositories\RepositoryInterface;

/**
 * Interface CategoryInterface.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
interface ProductsInterface extends RepositoryInterface {

    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getBySlug($slug);
}
