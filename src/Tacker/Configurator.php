<?php

namespace Tacker;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\ConfigCache;
use Pimple;

/**
 * @package Tacker
 */
class Configurator
{
    protected $debug = false;
    protected $cacheDir;
    protected $loader;
    protected $resources;

    public function __construct(LoaderInterface $loader, ResourceCollection $resources)
    {
        $this->loader = $loader;
        $this->resources = $resources;
    }

    public function getDebug()
    {
        return $this->debug;
    }

    public function getCacheDir()
    {
        return $this->cacheDir;
    }

    public function setDebug($debug)
    {
        $this->debug = $debug;
    }

    public function setCacheDir($cacheDir)
    {
        $this->cacheDir = $cacheDir;
    }

    public function configure(Pimple $pimple, $resource)
    {
        $cache = new ConfigCache(sprintf('%s/%s.php', $this->cacheDir, crc32($resource)), $this->debug);

        if (!$cache->isFresh()) {
            $parameters = $this->loader->load($resource);
        }

        if ($this->cacheDir && isset($parameters)) {
            $cache->write('<?php $parameters = ' . var_export($parameters, true) . ';', $this->resources->all());
        }

        if (!isset($parameters)) {
            require (string) $cache;
        }

        $this->build($pimple, $parameters);
    }

    protected function build(Pimple $pimple, array $parameters)
    {
        foreach ($parameters as $k => $v) {
            $pimple->offsetSet($k, $v);
        }
    }
}
