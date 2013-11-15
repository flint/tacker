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
    protected $normalizer;

    public function __construct(
        LoaderInterface $loader,
        Normalizer $normalizer,
        ResourceCollection $resources
    ) {
        $this->loader = $loader;
        $this->normalizer = $normalizer;
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
            $parameters = $this->normalize($this->loader->load($resource));
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

    protected function normalize(array $parameters)
    {
        foreach ($parameters as $k => $v) {
            if (is_array($v)) {
                $parameters[$k] = $this->normalize($v);
            } else {
                $parameters[$k] = $this->normalizer->normalize($v);
            }
        }

        return $parameters;
    }
}
