<?php
namespace IComeFromTheNet\Ledger\Entity;

/**
 * This allow a gateway to return a map of
 * temporal columns.
 * 
 * When I designed the datamodel I did not have a standard set of temporal
 * column names so need this mapping extension.
 * 
 */ 
interface TemporalGatewayInterface
{
    
    /**
     * Fetch the map of temporal columns
     * 
     * @return TemporalMapGateway
     * @access public
     */ 
    public function getTemporalColumns();


}
/* End of file */