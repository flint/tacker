<?php

namespace spec\Tacker\Normalizer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EnvironmentNormalizerSpec extends ObjectBehavior
{
    function it_replaces_placeholders()
    {
        putenv('NORMALIZE_THIS=normalized');

        $this->normalize('#NORMALIZE_THIS#')->shouldReturn('normalized');
        $this->normalize('#normalize_this#')->shouldReturn('#normalize_this#');
    }
}
