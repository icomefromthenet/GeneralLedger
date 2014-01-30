<?php

namespace IComeFromTheNet\Ledger;

use DBALGateway\Query\QueryInterface;
use Doctrine\Common\Collections\Collection;
use Aura\Marshal\Entity\GenericEntity;

/**
 * Describes a Repository
 * 
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.00
 * 
 */
interface RepositoryInterface 
{
    
    /**
     *  Return a sinlge domain entity.
     *  
     *  @return Aura\Marshal\Entity\GenericEntity
     *  @access public
     * 
     */
    public function findOne();
    
    /**
     * Select A collection of domain objects
     * 
     *  @access public
     *  @return Doctrine\Common\Collections\Collection
     */ 
    public function findMany();
    
    /**
     * Hand back a QueryObject 
     * 
     * @return DBALGateway\Query\QueryInterface
     * @access public
     */
    public function select();
    
}
/* End of File */