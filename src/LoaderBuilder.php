<?php

namespace Tacker;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Tacker\Loader\CacheLoader;
use Tacker\Loader\IniFileLoader;
use Tacker\Loader\JsonFileLoader;
use Tacker\Loader\NormalizerLoader;
use Tacker\Loader\PhpFileLoader;
use Tacker\Loader\YamlFileLoader;
use Tacker\Normalizer\ChainNormalizer;
use Tacker\Normalizer\EnvfileNormalizer;
use Tacker\Normalizer\EnvironmentNormalizer;

/**
 * Helps building a Loader with Cache, Normalization etc.
 *
 * @package Tacker
 */
final class LoaderBuilder
{
    private $paths;
    private $normalizer;
    private $resolver;
    private $locator;
    private $debug;
    private $cacheDir;
    private $normalizerConfigured = false;
    private $resolverConfigured = false;

    public function __construct(array $paths, $cacheDir = null, $debug = false)
    {
        $this->cacheDir   = $cacheDir;
        $this->debug      = $debug;
        $this->locator    = new FileLocator($paths);
        $this->normalizer = new ChainNormalizer;
        $this->resolver   = new LoaderResolver;
        $this->resources  = new ResourceCollection;
    }

    public static function create(array $paths, $cacheDir = null, $debug = false)
    {
        return new self($paths, $cacheDir, $debug);
    }

    public function configureNormalizers(callable $callable)
    {
        $this->normalizerConfigured = true;

        $callable($this->normalizer);

        return $this;
    }

    public function configureLoaders(callable $callable)
    {
        $this->resolverConfigured = true;

        $callable($this->resolver, $this->locator, $this->resources);

        return $this;
    }

    public function setCacheDir($cacheDir)
    {
        $this->cacheDir = $cacheDir;

        return $this;
    }

    public function setDebug($debug)
    {
        $this->debug = $debug;

        return $this;
    }

    public function build()
    {
        if (false == $this->resolverConfigured) {
            $this->addDefaultLoaders();
        }

        if (false == $this->normalizerConfigured) {
            $this->addDefaultNormalizers();
        }

        $loader = new CacheLoader($this->createNormalizerLoader(), $this->resources);
        $loader->setCacheDir($this->cacheDir);
        $loader->setDebug($this->debug);

        return $loader;
    }

    public function addDefaultLoaders()
    {
        $this->resolverConfigured = true;

        if (class_exists('Symfony\Component\Yaml\Yaml')) {
            $this->resolver->addLoader(new YamlFileLoader($this->locator, $this->resources));
        }

        $this->resolver->addLoader(new JsonFileLoader($this->locator, $this->resources));
        $this->resolver->addLoader(new PhpFileLoader($this->locator, $this->resources));
        $this->resolver->addLoader(new IniFileLoader($this->locator, $this->resources));

        return $this;
    }

    public function addDefaultNormalizers()
    {
        $this->normalizerConfigured = true;

        $this->normalizer->add(new EnvironmentNormalizer);
        $this->normalizer->add(new EnvfileNormalizer($this->locator));

        return $this;
    }

    private function createNormalizerLoader()
    {
        return new NormalizerLoader(new DelegatingLoader($this->resolver), $this->normalizer);
    }
}
