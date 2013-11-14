<?php

namespace Tacker\Normalizer;

/**
 * @package Tacker
 */
class PimpleNormalizer implements Normalizer
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
     * @param  string $value
     * @return string
     */
    public function normalize($value)
    {
        return preg_replace_callback(static::PLACEHOLDER, array($this, 'callback'), $value);
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

    /**
     * @param  mixed $value
     * @return mixed
     */
    protected function scalarToString($value)
    {
        switch (gettype($value)) {
            case 'resource':
            case 'object':
                throw new \RuntimeException('Unable to replace placeholder if its replacement is an object or resource.');
            case 'boolean':
                return $value ? 'true' : 'false';
            case 'NULL':
                return 'null';
            default:
                return (string) $value;
        }
    }
}
