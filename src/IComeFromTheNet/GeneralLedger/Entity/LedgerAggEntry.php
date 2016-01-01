<?php
namespace IComeFromTheNet\GeneralLedger\Entity;

use DateTime;


/**
 * A Daily Aggerate of all transactions for the given account
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class LedgerAggEntry
{
    public $oProcessDate;
    
    public $iAccountId;
    
    public $fBalance;
    
}
/* End of Class */