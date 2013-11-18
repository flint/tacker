<?php

namespace spec\Tacker\Normalizer;

class PimpleNormalizerSpec extends \PhpSpec\ObjectBehavior
{
    /**
     * @param Pimple $pimple
     */
    function let($pimple)
    {
        $this->beConstructedWith($pimple);
    }

    function it_replaces_placeholders($pimple)
    {
        $pimple->offsetGet('config.path')->willReturn(__DIR__);

        $this->normalize('%config.path%')->shouldReturn(__DIR__);
        $this->normalize('%CONFIG.PATH%')->shouldReturn('%CONFIG.PATH%');
    }

    function it_normalizes_complete_matches_to_precise_type($pimple)
    {
        $pimple->offsetGet('config.first')->willReturn(true);
        $pimple->offsetGet('config.second')->willReturn(false);
        $pimple->offsetGet('config.third')->willReturn(null);

        $this->normalize('%config.first%')->shouldReturn(true);
        $this->normalize('%config.second%')->shouldReturn(false);
        $this->normalize('%config.third%')->shouldReturn(null);
    }

    function it_normalizes_matches_in_strings($pimple)
    {
        $pimple->offsetGet('path')->willReturn('dir');

        $this->normalize('something.%path%.name')->shouldReturn('something.dir.name');
    }
}
