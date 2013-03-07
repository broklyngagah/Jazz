<?php

namespace Jazz\Provider;

use Jazz\Classes\Cache;
use Silex\ServiceProviderInterface;

/**
 * Description of CacheServiceProvider
 *
 * @author broklyn
 */
class CacheServiceProvider implements ServiceProviderInterface
{
    public function register(\Silex\Application $app, $dir="")
    {

        $app['cache'] = $app->share(function () {

            $cache = new Cache($dir);

            return $cache;

        });

    }

    public function boot(\Silex\Application $app)
    {
    }
}

