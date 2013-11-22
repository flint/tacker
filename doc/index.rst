Tacker
======

  "A worker who fastens things by tacking them (as with tacks or by spotwelding)"

Tacker is a config component that binds Symfony Config together into
a reuseable config loader for Pimple.

.. image:: https://travis-ci.org/flint/tacker.png?branch=master
  :target: https://travis-ci.org/flint/tacker

Features
--------

Works with ``yml``, ``ini``, and ``json``.

* Inherit configurations files by using a special ``@import``
* Mix different configuration formats while using ``@import``
* Read configuration files are cached if a ``cache_dir`` is set and ``debug`` is set to false.
* Simple for all users of Pimple such as Silex and Flint.
* Only dependant on Pimple and Symfony Config.

Install
-------

Use composer to install this beautiful library.

.. code-block:: json

  {
      "require" : {
          "flint/tacker" : "~1.0"
      }
  }

Getting Started
---------------

.. code-block:: php

  <?php
  
  use Symfony\Component\Config\Loader\LoaderResolver;
  use Symfony\Component\Config\FileLocator;
  use Tacker\Loader\JsonFileLoader;
  use Tacker\Normalizer\ChainNormalizer;
  
  $resources = new ResourceCollection;
  $loader = new JsonFileLoader(new FileLocator, $resources);
  
  $configurator = new Configurator(new LoaderResolver(array($loader)), new ChainNormalizer, $resources);
  $configurator->configure(new Pimple, 'config.{ini,json,yml}');

Replacing Values
~~~~~~~~~~~~~~~~

Tacker comes with support for replacing values from environment value and/or Pimple services.

For environment variables it matches ``#CAPITALIZED_NAME#`` and for Pimple it matches ``%service.name%``.

.. code-block:: php

  <?php
  
  use Tacker\Normalizer\EnvironmentNormalizer;
  use Tacker\Normalizer\PimpleNormalizer;
  use Tacker\Normalizer\ChainNormalizer;
  
  $normalizer = new ChainNormalizer(array(
      new EnvironmentNormalizer,
      new PimpleNormalizer(new Pimple),
  ));

Tests
-----

Tacker is spec tested with PhpSpec. You run the tests with:

.. code-block:: bash

  $ ./vendor/bin/phpspec run
