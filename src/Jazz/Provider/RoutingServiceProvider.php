<?php

namespace Jazz\Provider;

use Silex\Application;
use Jazz\Routing\Loader\NullLoader;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\Loader\XmlFileLoader;
use Symfony\Component\Routing\Loader\PhpFileLoader;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\Loader\DelegatingLoader;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\RouteCollection;

/**
 * @package Flint
 */
class RoutingServiceProvider implements \Silex\ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function register(Application $app)
    {
        $app->extend('routes', function (RouteCollection $routes, Application $app) {
            $loader     = new YamlFileLoader(new FileLocator(JAZZ_CONFIG_DIR));
            $collection = $loader->load('routing.yml');
            $routes->addCollection($collection);

            return $routes;
        });
    }

    /**
     * {@inheritDoc}
     */
    public function boot(Application $app)
    {
    }
}
