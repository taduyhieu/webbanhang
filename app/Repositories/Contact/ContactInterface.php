<?php

namespace Fully\Repositories\Contact;

use Fully\Repositories\RepositoryInterface;

/**
 * Interface ContactInterface.
 *
 * @author THC <thanhhaconnection@gmail.com>
 */
interface ContactInterface extends RepositoryInterface
{
    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getBySlug($slug);
}
