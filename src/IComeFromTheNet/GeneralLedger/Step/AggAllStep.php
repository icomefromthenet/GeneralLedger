<?php
namespace IComeFromTheNet\GeneralLedger\Step;

use IComeFromTheNet\GeneralLedger\Entity\LedgerTransaction;
use IComeFromTheNet\GeneralLedger\Entity\LedgerEntry;

/**
 * This will calculate the daily AGG for each account in the transaction.
 * 
 * If your not using the AGG tables then this step should not be used.
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class AggAllStep extends CommonStep
{
    
    
    
    
    public function process(LedgerTransaction $oLedgerTrans, array $aLedgerEntries, LedgerTransaction $oAdjLedgerTrans = null)
    {
        
                
    }

}
/* End of class */



