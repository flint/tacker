Tacker
======

Tacker makes configuration easy for you when using Pimple. It supports multiple file types, caching and replacing
values based on your Environment or a Pimple instance.

It is easy to get started just look at [it's documentation](http://flint.readthedocs.org/projects/tacker).

[![Build Status](https://travis-ci.org/flint/tacker.png?branch=master)](https://travis-ci.org/flint/tacker)
=======

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

use Symfony\Component\Config\FileLocator;
use Tacker\Loader\JsonFileLoader;
use Tacker\Loader\CacheLoader;
use Tacker\Loader\NormalizerLoader;
use Tacker\Normalizer\ChainNormalizer;
use Tacker\Configurator;

$resources = new ResourceCollection;
$loader = new JsonFileLoader(new FileLocator, $resources);

// add CacheLoader and NormalizerLoader
$loader = new CacheLoader(new NormalizerLoader($loader, new ChainNormalizer), $resources);

// load just the parameters
$parameters = $loader->load('config.{ini,json,yml}');

// or use cofigurator with pimple
$configurator = new Configurator($loader);
$configurator->configure(new Pimple, 'config.json');
```

### Replacing Values

Tacker comes with support for replacing values from environment value and/or Pimple services.

For environment variables it matches `#CAPITALIZED_NAME#` and for Pimple it matches `%service.name%`.

``` php
<?php

use Tacker\Normalizer\EnvironmentNormalizer;
use Tacker\Normalizer\PimpleNormalizer;
use Tacker\Normalizer\ChainNormalizer;

$normalizer = new ChainNormalizer(array(
    new EnvironmentNormalizer,
    new PimpleNormalizer(new Pimple),
));
```

Tests
-----

Tacker is spec tested with PhpSpec. You run the tests with:

``` bash
$ ./vendor/bin/phpspec run
```
