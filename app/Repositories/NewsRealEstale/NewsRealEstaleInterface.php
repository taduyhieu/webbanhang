<?php

namespace Fully\Repositories\NewsRealEstale;

use Fully\Repositories\RepositoryInterface;

/**
 * Interface NewsRealEstaleInterface.
 *
 * @author THC <thanhhaconnection@gmail.com>
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
