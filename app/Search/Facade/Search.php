<?php

namespace Fully\Search\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * Class Search.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class Search extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'search';
    }
}
