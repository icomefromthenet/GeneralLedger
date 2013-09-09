<?php
namespace Faker\Extension\Faker\Type;

use Faker\Components\Engine\EngineException;
use Faker\Components\Engine\Common\Type\Type;
use Faker\Components\Engine\Common\Utilities;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;


class Demo extends Type
{

    //  -------------------------------------------------------------------------

    /**
     * Generate a value
     * 
     * @return string 
     */
    public function generate($rows,&$values = array())
    {
        return '';
    }
    
    
   
    //  -------------------------------------------------------------------------
    
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition 
     */
    public function getConfigTreeExtension(NodeDefinition $rootNode)
    {
        return $rootNode;
    }
    
    
    //  -------------------------------------------------------------------------
    
}

/* End of File */