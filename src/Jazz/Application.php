<?php

namespace Jazz;

use Jazz\Provider\ConfigServiceProvider;
use Jazz\Provider\JazzServiceProvider;
use Jazz\Provider\RoutingServiceProvider;
use Silex\Provider\TwigServiceProvider;

/**
 * @package Jazz
 */
class Application extends \Silex\Application
{
    /**
     * Assigns rootDir and debug to the pimple container. Also replaces the
     * normal resolver with a ApplicationAware Resolver.
     *
     * @param string $rootDir
     * @param boolean $debug
     */
    public function __construct($rootDir, $debug = false)
    {
        parent::__construct(array(
            'root_dir' => $rootDir,
            'debug' => $debug,
        ));

        $this->register(new ConfigServiceProvider);
        $this->register(new RoutingServiceProvider);
        $this->register(new TwigServiceProvider);
        $this->register(new JazzServiceProvider);
    }

    /**
     * @param array $parameters
     */
    public function inject(array $parameters)
    {
        foreach ($parameters as $k => $v) {
            $this[$k] = $v;
        }
    }
}
