<?php

namespace Jazz\Provider;

use Jazz\Classes\Cache;
use Silex\ServiceProviderInterface;

/**
 * Description of CacheServiceProvider
 *
 * @author broklyn
 */
class CacheServiceProvider extends ServiceProviderInterface
{
    public function register(\Silex\Application $app)
    {

        $app['cache'] = $app->share(function () {

            $cache = new Bolt\Cache();

            return $cache;

        });

    }

    public function boot(SilexApplication $app)
    {
    }
}

