<?php

namespace spec\Tacker\Loader;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IniFileLoaderSpec extends ObjectBehavior
{
    /**
     * @param Tacker\Normalizer $normalizer
     * @param Symfony\Component\Config\FileLocatorInterface $locator
     * @param Tacker\ResourceCollection $resources
     */
    function let($normalizer, $locator, $resources)
    {
        $this->beConstructedWith($normalizer, $locator, $resources);
    }

    function it_normalizes_ini_files_when_loading($normalizer, $locator, $resources)
    {
        $locator->locate('config.ini')->willReturn(__DIR__ . '/../Fixtures/config.ini');
        $normalizer->normalize('hello = "world"' . "\n")->willReturn('hello = "jupiter"');

        $this->load('config.ini')->shouldReturn(array(
            'hello' => 'jupiter',
        ));
    }

    function it_does_not_support_inherited_configs($locator)
    {
        $locator->locate('inherit.ini')->shouldNotBeCalled();
        $locator->locate('config.ini')->shouldBeCalled()
            ->willReturn(__DIR__ . '/../Fixtures/config.ini');

        $this->load('config.ini')->shouldReturn(array());
    }
}
