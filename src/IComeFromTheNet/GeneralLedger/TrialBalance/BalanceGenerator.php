<?php
namespace IComeFromTheNet\GeneralLedger\TrialBalance;

use IComeFromTheNet\GeneralLedger\Exception\LedgerException;
use IComeFromTheNet\GeneralLedger\Entity\LedgerBalance;

/**
 *  This class will produce a trail balance.
 * 
 *  Debit accounts belong on the left of the accounting equation
 *  Credit accounts belong on the right of the accounting equation
 *  Extened Accounting Equation:  Assets + Expenses = Equity + Liabilities + Income 
 *           
 *  Example Set of account Using Accounts developed by National Standard Chart of Accounts
 *  From http://www.coag.gov.au/node/63
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class BalanceGenerator
{
    
    /**
     * @var AccountTree;
     */ 
    protected $oAccountTree;
    
    /**
     * @var array (array(LedgerBalance))
     */  
    protected $aAccountList;
    

    public function __construct(AccountTree $oAccountTree)
    {
        $this->oAccountTree = $oAccountTree;
        
    }
    


    //--------------------------------------------------------------------------
    # Get the balance of the left and right accounts
    
    
    public function buildTrialBalance()
    {
        $oAccountTree = $this->oAccountTree;
        
        # Process each root node
        $aRootNodes = $oAccountTree->getRootNodes();
    
    
    
        
    }
    
}
/* End of File */