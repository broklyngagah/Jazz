<?php

namespace Jazz;

/**
 * @package Jazz
 */
abstract class ApplicationAware implements ApplicationAwareInterface
{
    protected $app;

    /**
     * {@inheritDoc}
     */
    public function setApplication(Application $app = null)
    {
        $this->app = $app;
    }
}
