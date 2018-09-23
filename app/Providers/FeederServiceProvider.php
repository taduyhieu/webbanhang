<?php

namespace Fully\Providers;

use Illuminate\Support\ServiceProvider;
use Fully\Feeder\Feeder;

/**
 * Class FeederServiceProvider.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class FeederServiceProvider extends ServiceProvider
{
    /**
     * Register.
     */
    public function register()
    {
        $this->app->bind('feeder', 'Fully\Feeder\Feeder');
    }
}
