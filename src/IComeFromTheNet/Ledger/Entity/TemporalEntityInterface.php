<?php
namespace IComeFromTheNet\Ledger\Entity;


/**
 * Interface to allow Entity object to return
 * temporal fields without other classing knowing 
 * the field names.
 * 
 * For example an account can be opened while a voucher is enabled.
 * When I designed the datamodel I did not have a standard set of temporal
 * column names so need this mapping extension.
 * 
 */ 
interface TemporalEntityInterface
{
    
    /**
     * Fetch the temporal fields from this entity
     * 
     * @return TemporalMapEntity
     * @access public
     */ 
    public function getTemporalFields();
    
    
    
}
/* End of file */