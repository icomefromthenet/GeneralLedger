<?php
namespace IComeFromTheNet\Ledger;

use DBALGateway\Table\AbstractTable;

/**
 * Common Table that stored ProxyGatewayCollection allowing
 * other gateways to be aware of other database tables
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
abstract class SchemaAwareTable extends AbstractTable
{
    
    
    protected $oGatewayProxyCollection;
    
    /**
      *  sets the DBAL Table Gateway collection
      *
      *  @access public
      *  @return void
      *  @param GatewayProxyCollection $col
      */
    public function setGatewayCollection(GatewayProxyCollection $col)
    {
        $this->oGatewayProxyCollection = $col;
    }
    
    /**
      *  Fetches the DBAL Table Gateway collection
      *
      *  @access public
      *  @return GatewayProxyCollection
      */
    public function getGatewayCollection()
    {
        return $this->oGatewayProxyCollection;
    }

}
/* End of Class */
