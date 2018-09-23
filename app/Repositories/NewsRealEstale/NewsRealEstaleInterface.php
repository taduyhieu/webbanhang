<?php

namespace Fully\Repositories\NewsRealEstale;

use Fully\Repositories\RepositoryInterface;

/**
 * Interface NewsRealEstaleInterface.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
interface NewsRealEstaleInterface extends RepositoryInterface
{
    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getBySlug($slug);
}
