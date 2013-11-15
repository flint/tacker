Tacker
======

> A worker who fastens things by tacking them (as with tacks or by spotwelding)

Tacker is a config component that binds Symfony Config together into
a reuseable config loader for Pimple.

Features
--------

Works with `yml`, `ini`, and `json`.

 * Inherit configurations files by using a special `@import`
 * Mix different configuration formats while using `@import`
 * Read configuration files are cached if a `cache_dir` is set and `debug` is set to false.
 * Simple for all users of Pimple such as `Silex`, `Flint`.
 * Only dependant on Pimple and Symfony Config.

Install
-------

Use composer to install this beautiful library.

``` json
{
    "require" : {
        "flint/tacker" : "~1.0"
    }
}
```

Getting Started
---------------

``` php
<?php

use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\FileLocator;
use Tacker\Loader\JsonFileLoader;
use Tacker\Normalizer\ChainNormalizer;

$resources = new ResourceCollection;
$loader = new JsonFileLoader(new ChainNormalizer, new FileLocator, $resources);

$configurator = new Configurator(new LoaderResolver(array($loader)), $resources);
$configurator->configure(new Pimple);
```

Tests
-----

Tacker is spec tested with PhpSpec. You run the tests with:

``` bash
$ ./vendor/bin/phpspec run
```
