<?php

namespace Tacker\Normalizer;

/**
 * @package Tacker
 */
class EnvironmentNormalizer implements \Tacker\Normalizer
{
    const PLACEHOLDER = '{##|#([A-Z0-9_]+)#}';

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
            return '##';
        }

        return getenv($matches[1]);
    }
}
