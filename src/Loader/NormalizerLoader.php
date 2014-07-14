<?php

namespace Tacker\Loader;

use Symfony\Component\Config\Loader\LoaderInterface;
use Tacker\Normalizer;

class NormalizerLoader extends \Symfony\Component\Config\Loader\Loader
{
    private $normalizer;
    private $loader;

    public function __construct(LoaderInterface $loader, Normalizer $normalizer)
    {
        $this->loader = $loader;
        $this->normalizer = $normalizer;
    }

    public function load($resource, $type = null)
    {
        $parameters = $this->loader->load($resource, $type);

        return array_map([$this, 'normalize'], $parameters);
    }

    public function supports($resource, $type = null)
    {
        return $this->loader->supports($resource, $type);
    }

    private function normalize($value)
    {
        if (is_array($value)) {
            return array_map([$this, 'normalize'], $value);
        }

        return $this->normalizer->normalize($value);
    }
}
