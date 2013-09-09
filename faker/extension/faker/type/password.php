<?php
namespace Faker\Extension\Faker\Type;

use Faker\Components\Engine\EngineException;
use Faker\Components\Engine\Common\Type\Type;
use Faker\Components\Engine\Common\Utilities;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;


class Password extends Type
{

    //  -------------------------------------------------------------------------

    /**
     * Generate a value
     * 
     * @return string 
     */
    public function generate($rows,&$values = array())
    {
        $format = $this->getOption('format');
        return md5($this->getUtilities()->generateRandomAlphanumeric($format,$this->getGenerator(),$this->getLocale()));
    }
    
    
   
    //  -------------------------------------------------------------------------
    
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition 
     */
    public function getConfigTreeExtension(NodeDefinition $rootNode)
    {
        return $rootNode
            ->children()
                ->scalarNode('format')
                    ->info('Text format to generate')
                    ->example('xxxxx ccccCC')
                ->end()
            ->end();
            
    }
    
    
    //  -------------------------------------------------------------------------
}
