<?php


namespace Gomobile\GomobileNOsixBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder("gomobile_nosix");
        $treeBuilder->getRootNode()
            ->children()
            ->scalarNode("login")->defaultValue("")->end()
            ->scalarNode("password")->defaultValue("")->end()
            ->booleanNode("is_local")->defaultFalse()->end()
            ->end();

        return $treeBuilder;
    }
}