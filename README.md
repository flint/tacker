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
 * Read configuration files are cached if a `cache_dir` and `debug` is set.
 * Simple for all users of Pimple such as `Silex`, `Flint`.
 * Only dependant on Pimple and Symfony Config.

 Getting Started
 ---------------

 Coming Soon!

 Tests
 -----

 Tacker is spec tested with PhpSpec. You run the tests with:

 ``` bash
 $ ./vendor/bin/phpspec run
 ```
