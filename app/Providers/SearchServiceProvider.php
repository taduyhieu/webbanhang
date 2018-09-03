<?php

namespace Fully\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class SearchServiceProvider.
 *
 * @author THC <thanhhaconnection@gmail.com>
 */
class SearchServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('search', 'Fully\Search\Search');
    }
}
