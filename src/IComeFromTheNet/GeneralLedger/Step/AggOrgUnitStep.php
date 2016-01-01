<?php
namespace IComeFromTheNet\GeneralLedger\Step;

use IComeFromTheNet\GeneralLedger\Entity\LedgerTransaction;
use IComeFromTheNet\GeneralLedger\Entity\LedgerEntry;

/**
 * This will calculate the daily AGG for each account and org unit.
 * 
 * If your not using the AGG tables then this step should not be used.
 * 
 * Only save the org unit of this transaction.
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class AggOrgUnitStep extends CommonStep
{
    
    
    
    
    public function process(LedgerTransaction $oLedgerTrans, array $aLedgerEntries, LedgerTransaction $oAdjLedgerTrans = null)
    {
        
                
    }

}
/* End of class */



