<?php

namespace spec\Tacker\Normalizer;

class EnvironmentNormalizerSpec extends \PhpSpec\ObjectBehavior
{
    function it_replaces_placeholders()
    {
        putenv('NORMALIZE_THIS=normalized');

        $this->normalize('#NORMALIZE_THIS#')->shouldReturn('normalized');
        $this->normalize('#normalize_this#')->shouldReturn('#normalize_this#');
    }
}
