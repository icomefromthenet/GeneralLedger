<?php
namespace IComeFromTheNet\Ledger\Entity;

/**
  *  Represent an Ledger entry.
  *
  *  Each entry is bound to a ledger transaction
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class LedgerEntry
{
    
    // -----------------------------------------------
    # Entry Meta
    
    protected $accountID;
    
    protected $ledgerTransactionID;
    
    protected $amount;
    
    protected $dateNoticed;    
    
    protected $dateOccured;

    /*
    *
    * @public
}
/* End of Class */
