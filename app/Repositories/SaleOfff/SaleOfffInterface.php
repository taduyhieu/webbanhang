<?php

namespace Fully\Repositories\SaleOfff;

use Fully\Repositories\RepositoryInterface;

/**
 * Interface CategoryInterface.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
interface SaleOfffInterface extends RepositoryInterface {

    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getBySlug($slug);
}
