<?php

namespace spec\Tacker;

class ConfiguratorSpec extends \PhpSpec\ObjectBehavior
{
    /**
     * @param Symfony\Component\Config\Loader\LoaderInterface $loader
     * @param Pimple $pimple
     */
    function let($loader, $pimple)
    {
        $this->beConstructedWith($loader);

        // make sure that the directory used for specs are clean
        @array_map('unlink', glob(sys_get_temp_dir() . '/tacker/*'));
    }

    function it_caches_config($loader, $pimple)
    {
        $this->setCacheDir(sys_get_temp_dir() . '/tacker');

        $loader->load('config.json')->willReturn(array())
            ->shouldBeCalledTimes(1);

        $this->configure($pimple, 'config.json');
        $this->configure($pimple, 'config.json');
    }

    function it_loads_config_file($loader, $pimple)
    {
        $loader->load('config.json')->willReturn(array('hello' => 'world'))
            ->shouldBeCalled();

        $pimple->offsetSet('hello', 'world')->shouldBeCalled();

        $this->configure($pimple, 'config.json');
    }

    function it_allows_setting_debug_and_cache_dir()
    {
        $this->getDebug()->shouldReturn(false);
        $this->getCacheDir()->shouldReturn(null);

        $this->setDebug(true);
        $this->setCacheDir('/path');

        $this->getDebug()->shouldReturn(true);
        $this->getCacheDir()->shouldReturn('/path');
    }
}
