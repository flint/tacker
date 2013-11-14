<?php

namespace spec\Tacker;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ResourceCollectionSpec extends ObjectBehavior
{
    /**
     * @param Symfony\Component\Config\Resource\DirectoryResource $directory
     * @param Symfony\Component\Config\Resource\FileResource $file
     * @param Symfony\Component\Config\Resource\ResourceInterface $interface
     */
    function its_a_collection_of_resources($directory, $file, $interface)
    {
        $this->add($directory);
        $this->add($file);
        $this->add($interface);

        $this->all()->shouldReturn(array($directory, $file, $interface));
    }
}
