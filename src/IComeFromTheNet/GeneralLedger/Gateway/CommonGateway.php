<?php
namespace IComeFromTheNet\GeneralLedger\Gateway;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Types\Type as AbstractType;
use DBALGateway\Table\SchemaAwareTable;
use DBALGateway\Table\TableInterface;
use DBALGateway\Table\TableEvent;
use DBALGateway\Table\TableEvents;
use DBALGateway\Exception as GatewayException;

/**
 * Table gateway pt_system
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class CommonGateway extends SchemaAwareTable implements TableInterface
{
    
    /**
     * @var CommonQuery
     */ 
    protected $head;
    
    
    public function getAdapter()
    {
        return $this->getAdapater();
    }
    
    /**
     * Proxy the bound query builder to DBAL::fetchColumn
     * 
     * @return mixed
     * @access public
     * @param integer $iColumn the column number to return
     */ 
    public function fetchColumn($iColumn)
    {
        $this->event_dispatcher->dispatch(TableEvents::PRE_SELECT,new TableEvent($this));
        $result = null;
        
        try {
            
            $sSql = $this->head->getSql();
            $aParam = $this->head->getParameters();
            $aTypes = $this->head->getParameterTypes();
            
            
            $result = $this->getAdapter()
                           ->executeQuery($sSql,$aParam,$aTypes)
                           ->fetchColumn($iColumn);

        } catch(DBALException $e) {
            throw new GatewayException($e->getMessage());
        }
        
        $this->event_dispatcher->dispatch(TableEvents::POST_SELECT,new TableEvent($this,$result));
        
        $this->clear();
        
        return $result;  
    }
    
    /**
     * Return the now date from the db server
     * 
     * @return DateTime
     * @access public
     */ 
    public function getNow()
    {
        $sNow = $this->newQueryBuilder()
                ->select($this->getAdapter()->getDatabasePlatform()->getCurrentDateSQL())
                ->from($this->getMetaData()->getName())
                ->end()
                ->fetchColumn(0);
        
                
        $oDateColumn = AbstractType::getType(AbstractType::DATE);   

        return $oDateColumn->convertToPHPValue($sNow,$this->getAdapter()->getDatabasePlatform());
    }
    
    /**
      *  Create a new instance of the querybuilder
      *
      *  @access public
      *  @return QueryBuilder
      */
    public function newQueryBuilder()
    {
        $this->head = new CommonQuery($this->adapter,$this);
        $this->head->setDefaultAlias($this->getTableQueryAlias());
        
       return $this->head;
       
    }
    
}
/* End of Class */