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
    

    public function __construct(AccountTree $oAccountTree)
    {
        $this->oAccountTree = $oAccountTree;
    }
    

    //--------------------------------------------------------------------------
    # Get the balance of the left and right accounts
    
    
    public function buildTrialBalance()
    {
        $oAccountTree = $this->oAccountTree;

        $aAccountList = array();
        
        $fTotalCredits = 0;
        $fTotalDebits  = 0;
    
        
        # Process each root node
        foreach($oAccountTree->getRootNodes() as $oAccNode) {
            $oBalance = new LedgerBalance();
            
            $oBalance->sAccountNumber = $oAccNode->getAccountNumber();
            $oBalance->sAccountName   = $oAccNode->getAccountName();
            
            if(true === $oAccNode->isCredit()) {
                $oBalance->fCredit = $oAccNode->getBalance();     
                $fTotalCredits += $oBalance->fCredit;
                
            } else {
                $oBalance->fDebit  = $oAccNode->getBalance();
                $fTotalDebits += $oBalance->fDebit;
            }
            
            
            $aAccountList[] = $oBalance;             
        } 
            
        # process the subtotal row which tell us
        # if our ledger is in balance
            
        $oTotal = new LedgerBalance();
        
        $oTotal->sAccountNumber = null;
        $oTotal->sAccountName = 'Subtotal';
        $oTotal->fDebit = $fTotalDebits;
        $oTotal->fCredit = $fTotalCredits;
    
        $aAccountList[] = $oTotal;
        
    
        return $aAccountList;            
    }
    
}
/* End of File */