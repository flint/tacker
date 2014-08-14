<?php

namespace Tacker\Loader;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Loader\LoaderInterface;

class ProcessorLoader extends \Symfony\Component\Config\Loader\Loader
{
    private $loader;
    private $configuration;

    public function __construct(LoaderInterface $loader, ConfigurationInterface $configuration)
    {
        $this->loader = $loader;
        $this->configuration = $configuration;
    }

    public function load($resource, $type = null)
    {
        $parameters = $this->loader->load($resource, $type);

        return $this->processConfiguration($parameters);
    }

    public function supports($resource, $type = null)
    {
        return $this->loader->supports($resource, $type);
    }

    private function processConfiguration(array $parameters)
    {
        $processor = new Processor;

        return $processor->processConfiguration($this->configuration, [$parameters]);
    }
}
