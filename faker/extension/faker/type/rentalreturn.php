<?php
namespace Faker\Extension\Faker\Type;

use Faker\Components\Engine\EngineException;
use Faker\Components\Engine\Common\Type\Type;
use Faker\Components\Engine\Common\Utilities;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;


class RentalReturn extends Type
{

    //  -------------------------------------------------------------------------

    /**
     * Generate a value
     * 
     * @return string 
     */
    public function generate($rows,&$values = array())
    {
        $return_date = clone $values['rental_date'];
        
        return $return_date->modify('+'.ceil($this->getGenerator()->generate(0,7)).' days');
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
