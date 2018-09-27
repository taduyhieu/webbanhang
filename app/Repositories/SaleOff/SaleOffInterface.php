<?php

namespace Fully\Repositories\SaleOff;

use Fully\Repositories\RepositoryInterface;

/**
 * Interface CategoryInterface.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
interface SaleOffInterface extends RepositoryInterface {

    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getBySlug($slug);
}
