<?php

namespace Tacker\Normalizer;

/**
 * @package Tacker
 */
class PimpleNormalizer extends EnvironmentNormalizer
{
    const PLACEHOLDER = '{%%|%([a-z0-9_.]+)%}';

    protected $pimple;

    /**
     * @param Pimple $pimple
     */
    public function __construct(\Pimple $pimple = null)
    {
        $this->pimple = $pimple;
    }

    /**
     * @param  array $matches
     * @return mixed
     */
    protected function callback($matches)
    {
        if (!isset($matches[1])) {
            return '%%';
        }

        return $this->scalarToString($this->pimple[$matches[1]]);
    }

}
