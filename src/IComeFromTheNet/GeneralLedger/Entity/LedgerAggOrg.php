<?php
namespace IComeFromTheNet\GeneralLedger\Entity;

use DateTime;

/**
 * A Daily Aggerate of all transactions for the given account and org unit
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class LedgerAggOrg extends LedgerAggEntry
{
    public $iOrgUnitID;
    
}
/* End of Class */