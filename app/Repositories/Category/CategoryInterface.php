<?php

namespace Fully\Repositories\Category;

use Fully\Repositories\RepositoryInterface;

/**
 * Interface CategoryInterface.
 *
 * @author THC <thanhhaconnection@gmail.com>
 */
interface CategoryInterface extends RepositoryInterface {

    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getBySlug($slug);
}
