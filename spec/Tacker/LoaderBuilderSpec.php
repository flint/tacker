<?php

namespace spec\Tacker;

use PhpSpec\ObjectBehavior;

class LoaderBuilderSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith([]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tacker\LoaderBuilder');
    }

    function it_builds_loader()
    {
        $this->build()->shouldHaveType('Tacker\Loader\CacheLoader');
    }
}
