<?php

namespace Tacker\Normalizer;

use Tacker\Normalizer;

/**
 * @package Tacker
 */
class ChainNormalizer implements \Tacker\Normalizer
{
    private $normalizers = [];

    /**
     * @param array $normalizers
     */
    public function __construct(array $normalizers = [])
    {
        array_map([$this, 'add'], $normalizers);
    }

    /**
     * @param Normalizer $normalizer
     */
    public function add(Normalizer $normalizer)
    {
        $this->normalizers[] = $normalizer;
    }

    /**
     * {@inheritDoc}
     */
    public function normalize($value)
    {
        foreach ($this->normalizers as $normalizer) {
            $value = $normalizer->normalize($value);
        }

        return $value;
    }
}
