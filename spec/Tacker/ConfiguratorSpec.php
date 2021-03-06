<?php

namespace spec\Tacker;

use PhpSpec\ObjectBehavior;

class ConfiguratorSpec extends ObjectBehavior
{
    /**
     * @param Symfony\Component\Config\Loader\LoaderInterface $loader
     */
    function let($loader)
    {
        $this->beConstructedWith($loader);
    }

    /**
     * @param Pimple\Container $pimple
     */
    function it_adds_parameters_on_pimple($pimple, $loader)
    {
        $pimple->offsetSet('hello', 'world')->shouldBeCalled();

        $loader->load('config.json')->willReturn(array('hello' => 'world'));

        $this->configure($pimple, 'config.json');
    }
}
