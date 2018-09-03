<?php

namespace Fully\Feeder\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * Class Feeder.
 *
 * @author THC <thanhhaconnection@gmail.com>
 */
class Feeder extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'feeder';
    }
}
