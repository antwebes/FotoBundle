<?php

namespace ant\FotoBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AntFotoExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
	
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('form.xml');
        $loader->load('orm.xml');
        $loader->load('user.xml');
        
        $container->setParameter('ant_foto.foto_class', $config['foto_class']);
        $container->setParameter('ant_foto.user_class', $config['user_class']);
        $container->setParameter('ant_foto.form.name', $config['form']['name']);
        $container->setParameter('ant_foto.form.type', $config['form']['type']);
        $container->setAlias('ant_foto.driver.object_manager', $config['object_manager']);
     //   $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
       // $loader->load('services.yml');
    }
}

