<?php
namespace IComeFromTheNet\Ledger\DB;

use DBALGateway\Table\TableInterface;
use IComeFromTheNet\Ledger\DB\TemporalMap;

/**
 * This allow a gateway to return a map of
 * temporal columns.
 * 
 * When I designed the datamodel I did not have a standard set of temporal
 * column names so need this mapping extension.
 * 
 * Inherit from table interface to ensure that the
 * final implemenator is a TableGateway.
 * 
 */ 
interface TemporalGatewayInterface extends TableInterface
{
    
    /**
     * Fetch the map of temporal columns
     * 
     * @return TemporalMap
     * @access public
     */ 
    public function getTemporalColumns();


}
/* End of file */