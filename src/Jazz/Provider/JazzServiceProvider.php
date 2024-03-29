<?php

namespace Jazz\Provider;

use Symfony\Component\HttpKernel\EventListener\ExceptionListener;
use Jazz\Controller\ControllerResolver;
use Silex\Application;

/**
 * @package Jazz
 */
class JazzServiceProvider implements \Silex\ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function register(Application $app)
    {
        $app['exception_controller'] = 'Flint\\Controller\\ExceptionController::showAction';

        $app['exception_handler'] = $app->share(function ($app) {
            return new ExceptionListener($app['exception_controller'], $app['logger']);
        });

        $app['resolver'] = $app->share($app->extend('resolver', function ($resolver, $app) {
            return new ControllerResolver($resolver, $app);
        }));

        $app['twig.loader.filesystem'] = $app->share($app->extend('twig.loader.filesystem', function ($loader, $app) {
            $loader->addPath(__DIR__ . '/../Resources/views', 'Jazz');

            return $loader;
        }));
    }

    /**
     * {@inheritDoc}
     */
    public function boot(Application $app)
    {
    }
}
