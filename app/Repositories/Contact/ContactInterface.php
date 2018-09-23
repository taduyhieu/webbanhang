<?php

namespace Fully\Repositories\Contact;

use Fully\Repositories\RepositoryInterface;

/**
 * Interface ContactInterface.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
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
