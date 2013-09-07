<?php
namespace IComeFromTheNet\Ledger\Entity;

/**
  *  Represent an Account entry.
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class AccountEntry
{
    
    // -----------------------------------------------
    # Entry Meta
    
    protected $accountID;
    
    protected $ledgerTransactionID;
    
    protected $amount;
    
    protected $dateNoticed;    
    
    protected $dateOccured;
    
    
    
    // -----------------------------------------------
    # extra descriptiors
    
    /*
     * @var integer Tag Reference
     */
    protected $tagID;
    
    /*
     * @var string a name of a cost center
     */
    protected $costCenter;
    
    /*
     * @var integer a user reference
     */
    protected $userID;
    
}
/* End of Class */
