<?php


namespace Gomobile\GomobileNOsixBundle\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class GomobileNOsixExtension extends Extension
{

    /**
     * @inheritDoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);

        // Set parameters
        $container->setParameter("gomobile_nosix.login", $config["login"]);
        $container->setParameter("gomobile_nosix.password", $config["password"]);
        $container->setParameter("gomobile_nosix.is_local", $config["is_local"]);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . "/../Resources/config"));
        $loader->load("services.yaml");

    }
}