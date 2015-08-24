<?php
namespace IComeFromTheNet\Ledger;

use \IteratorAggregate;
use \ArrayIterator;
use Doctrine\DBAL\Schema\Schema;
use DBALGateway\Table\AbstractTable;
use IComeFromTheNet\Ledger\Exception\LedgerException;


class GatewayProxyCollection implements IteratorAggregate
{
    /**
     * Doctrine\DBAL\Schema\Schema
     */
    protected $oSchema;
    
    /**
     * @var array[DBALGateway\Table\AbstractTable] | array[Closure] contain all Gateways or proxy closure that return a gateway 
     */ 
    protected $aGatewayColection;
    
    
    public function __construct(Schema $oSchema)
    {
        $this->oSchema = $oSchema;
        $this->aGatewayColection = array();
    }
    
    /**
     * Adds a gateway to this proxy collection
     * 
     * @param string  $sInternalTableName
     * @param Closure $oGatewayConstructor
     */ 
    public function addGateway($sInternalTableName, \Closure $oGatewayConstructor)
    {
        if(true === $this->gatewayExistsAt($sInternalTableName)) {
            throw new LedgerException("The key $sInternalTableName already exists");
        }
        
        $this->aGatewayColection[$sInternalTableName] = $oGatewayConstructor;
        
    }
    
    /**
     * Does the gateway exists at this internal name
     * 
     * @param string $sInternalTableName
     * @return boolean 
     */ 
    public function gatewayExistsAt($sInternalTableName) 
    {
        return isset($this->aGatewayColection[$sInternalTableName]);
    }
    
    /**
     * Fetch the gateway and if not constructed yet will execute the
     * closure and return the TableGateway
     * 
     * @return DBALGateway\Table\AbstractTable
     * @param string $sInternalTableName the internal table name used when added
     */ 
    public function getGateway($sInternalTableName)
    {
       if(false === $this->gatewayExistsAt($sInternalTableName)) {
           throw new LedgerException("The key $sInternalTableName does not exist");
       }    
    
    
       if(false === $this->aGatewayColection[$sInternalTableName] instanceof AbstractTable ) {
           $this->aGatewayColection[$sInternalTableName] = $this->aGatewayColection[$sInternalTableName]();
       }
        
        
        return $this->aGatewayColection[$sInternalTableName];
        
    }
    
    
    /**
     * Return the assigned collection
     * 
     * @access public
     * @return Doctrine\DBAL\Schema\Schema
     */ 
    public function getSchema()
    {
        return $this->oSchema;
        
    }
    
    //--------------------------------------------------------------------------
    #IteratorAggregate 
    
    
    public function getIterator()
    {
        return new ArrayIterator($this->aGatewayColection);
    }
    
    
    
    
}
/* End of Class */