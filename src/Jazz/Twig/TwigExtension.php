<?php

namespace Jazz\Twig;

use Jazz;
use Jazz\Library\Util;

class TwigExtension extends \Twig_Extension
{

    private $app;

    public function __construct(\Silex\Application $app)
    {
        $this->app = $app;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('printDump', array($this, 'printDump'), array('is_safe' => array('html'))),
        );
    }

    public function printDump($val)
    {
        $output = Util::var_dump($val, true);
        return $output;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'jazz';
    }
}