<?php
namespace IComeFromTheNet\Ledger\Test\Base\Mock;

use DBALGateway\Builder\BuilderInterface;
use Aura\Marshal\Entity\BuilderInterface as EntityBuilderInterface;


class MockBuilder implements BuilderInterface, EntityBuilderInterface
{
    
   
    public function newInstance(array $data)
    {
        return $this->build($data);
    }
   
   
  
    public function build($data)
    {
        return $data
        
    }
   
    public function demolish($entity)
    {
        return $data;
    }

}
/* End of File */