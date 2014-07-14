<?php

namespace Tacker;

use Symfony\Component\Config\Loader\LoaderInterface;
use Pimple\Container;

class Configurator
{
    private $loader;

    public function __construct(LoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    public function configure(Container $pimple, $resource)
    {
        $parameters = $this->loader->load($resource);

        foreach ($parameters as $k => $v) {
            $pimple->offsetSet($k, $v);
        }
    }
}
