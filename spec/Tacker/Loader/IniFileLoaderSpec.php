<?php

namespace spec\Tacker\Loader;

use Symfony\Component\Config\FileLocator;

class IniFileLoaderSpec extends \PhpSpec\ObjectBehavior
{
    /**
     * @param Tacker\Normalizer $normalizer
     * @param Tacker\ResourceCollection $resources
     */
    function let($normalizer, $resources)
    {
        $locator = new FileLocator(array(__DIR__ . '/../Fixtures'));

        $this->beConstructedWith($normalizer, $locator, $resources);
    }

    function it_normalizes_ini_files_when_loading($normalizer, $resources)
    {
        $normalizer->normalize('hello = "world"' . "\n")->willReturn('hello = "jupiter"');

        $this->load('config.ini')->shouldReturn(array(
            'hello' => 'jupiter',
        ));
    }

    function it__supports_inherited_configs($normalizer)
    {
        $normalizer->normalize('@import = "config.ini"' . "\n")->shouldBeCalled()
            ->willReturn('@import = "config.ini"');

        $normalizer->normalize('hello = "world"' . "\n")->shouldBeCalled()
            ->willReturn('hello = "world"');

        $this->load('inherit.ini')->shouldReturn(array(
            'hello' => 'world',
        ));
    }
}
