<?php

namespace spec\Tacker\Normalizer;

class EnvironmentNormalizerSpec extends \PhpSpec\ObjectBehavior
{
    function it_replaces_placeholders()
    {
        putenv('TACKER_NORMALIZE=normalized');
        putenv('tacker_lowercase=normalized');

        $this->normalize('#TACKER_NORMALIZE#')->shouldReturn('normalized');
        $this->normalize('#tacker_lowercase#')->shouldReturn('#tacker_lowercase#');
    }
}
