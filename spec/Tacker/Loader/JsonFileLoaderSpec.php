<?php

namespace spec\Tacker\Loader;

use Prophecy\Argument;
use Symfony\Component\Config\FileLocator;

class JsonFileLoaderSpec extends \PhpSpec\ObjectBehavior
{
    /**
     * @param Tacker\Normalizer $normalizer
     * @param Tacker\ResourceCollection $resources
     */
    function let($normalizer, $resources)
    {
        $locator = new FileLocator(array(__DIR__ . '/../Fixtures/json'));

        $this->beConstructedWith($normalizer, $locator, $resources);
    }

    function it_normalizes_files_when_loading($normalizer, $resources)
    {
        $normalizer->normalize(Argument::any())->shouldBeCalled()
            ->willReturnArgument();

        $this->load('config.json')->shouldReturn(array(
            'hello' => 'world',
        ));
    }

    function it_supports_inherited_configs($normalizer)
    {
        $normalizer->normalize(Argument::any())->willReturnArgument();

        $this->load('inherit.json')->shouldReturn(array(
            'hello' => 'world',
        ));
    }
}
