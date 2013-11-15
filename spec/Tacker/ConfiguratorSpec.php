<?php

namespace spec\Tacker;

use Prophecy\Argument;

class ConfiguratorSpec extends \PhpSpec\ObjectBehavior
{
    /**
     * @param Symfony\Component\Config\Loader\LoaderInterface $loader
     * @param Tacker\Normalizer $normalizer
     * @param Tacker\ResourceCollection $resources
     * @param Pimple $pimple
     */
    function let($loader, $normalizer, $resources, $pimple)
    {
        $normalizer->normalize(Argument::any())->willReturnArgument();

        $this->beConstructedWith($loader, $normalizer, $resources);

        // make sure that the directory used for specs are clean
        @array_map('unlink', glob(sys_get_temp_dir() . '/tacker/*'));
    }

    /**
     * @param Symfony\Component\Config\Resource\ResourceInterface $resource
     */
    function it_reloads_config_when_resources_change_in_debug($resource, $loader, $resources, $pimple)
    {
        $this->setDebug(true);
        $this->setCacheDir(sys_get_temp_dir() . '/tacker');

        $resources->all()->willReturn(array($resource));
        $resource->isFresh(Argument::any())->willReturn(false);

        $loader->load('debug.json')->willReturn(array('hello' => 'world'))
            ->shouldBeCalledTimes(2);

        $this->configure($pimple, 'debug.json');
        $this->configure($pimple, 'debug.json');
    }

    function it_caches_config($loader, $pimple, $normalizer)
    {
        $this->setCacheDir(sys_get_temp_dir() . '/tacker');

        $loader->load('config.json')->willReturn(array('hello' => 'world'))
            ->shouldBeCalledTimes(1);

        $normalizer->normalize('world')->shouldBeCalledTimes(1);

        $this->configure($pimple, 'config.json');
        $this->configure($pimple, 'config.json');
    }

    function it_normalizes_parameters($pimple, $loader, $normalizer)
    {
        $loader->load('config.json')->willReturn(array(
            'moon' => 'universe',
            'hello' => array(
                'name' => 'jupiter',
            ),
        ));

        $normalizer->normalize('universe')->shouldBeCalled();
        $normalizer->normalize('jupiter')->shouldBeCalled();

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
