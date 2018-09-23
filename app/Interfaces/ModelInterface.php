<?php

namespace Fully\Interfaces;

/**
 * Class ModelInterface.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
interface ModelInterface
{
    /**
     * @param $value
     *
     * @return mixed
     */
    public function setUrlAttribute($value);

    /**
     * @return mixed
     */
    public function getUrlAttribute();
}
