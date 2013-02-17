<?php

namespace ant\FotoBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;


/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ant_foto');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.
        $rootNode
	        ->children()
	        	->scalarNode('db_driver')->cannotBeOverwritten()->isRequired()->cannotBeEmpty()->end()
	        	->scalarNode('foto_class')->defaultValue('chatea\FotoBundle\Entity\Foto')->end()
	        	->scalarNode('object_manager')->isRequired()->cannotBeEmpty()->end()
	        ->end()
	        ->children()	        	
		        ->arrayNode('form')
			        ->addDefaultsIfNotSet()
			        ->canBeUnset()
			        ->children()
			        	->scalarNode('type')->defaultValue('ant_foto_type')->end()
				        ->scalarNode('name')->defaultValue('ant_foto_form_name')->end()
			        ->end()
		        ->end()
	        ->end()
        ;
        
        
        
        return $treeBuilder;
    }
}
