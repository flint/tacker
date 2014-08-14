<?php

namespace spec\Tacker\Loader;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class ProcessorLoaderSpec extends \PhpSpec\ObjectBehavior
{
    /**
     * @param Symfony\Component\Config\Loader\LoaderInterface $loader
     * @param Symfony\Component\Config\Definition\ConfigurationInterface $configuration
     */
    function let($loader, $configuration)
    {
        $this->beConstructedWith($loader, $configuration);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Tacker\Loader\ProcessorLoader');
    }

    function it_processes_configuration($loader, $configuration)
    {
        $builder = new TreeBuilder;
        $root = $builder->root('');
        $root
            ->children()
                ->booleanNode('auto_connect')
                    ->defaultTrue()
                ->end()
            ->end()
        ;


        $configuration->getConfigTreeBuilder()->willReturn($builder);

        $loader->load('file', null)->willReturn([]);

        $this->load('file')->shouldReturn(['auto_connect' => true]);
    }

    function it_delegates_supports_to_loader($loader)
    {
        $loader->supports('php', null)->willReturn(false)->shouldBeCalled();
        $loader->supports('yml', null)->willReturn(true)->shouldBeCalled();

        $this->supports('php')->shouldReturn(false);
        $this->supports('yml')->shouldReturn(true);
    }
}
