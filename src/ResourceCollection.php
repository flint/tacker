<?php

namespace Tacker;

use Symfony\Component\Config\Resource\ResourceInterface;

class ResourceCollection
{
    private $resources = [];

    public function add(ResourceInterface $resource)
    {
        $this->resources[] = $resource;
    }

    public function all()
    {
        return $this->resources;
    }
}
