<?php
namespace IComeFromTheNet\GeneralLedger;

use DateTime;
use IComeFromTheNet\GeneralLedger\TrialBalance\BalanceGenerator;
use IComeFromTheNet\GeneralLedger\TrialBalance\EntrySource;
use IComeFromTheNet\GeneralLedger\TrialBalance\AggAllSource;
use IComeFromTheNet\GeneralLedger\TrialBalance\AccountTreeBuilder;

/**
 * Will Build a Trial Balance.
 * 
 * A Trial Balance is a audit function where check if the ledger is in balance.
 * meaning all debits equals credits. It is also useed to list account balances 
 * for display in a UI.
 * 
 * Accounts on the left are known as debit accounts.
 * Accounts on the right are known as credit accounts.
 * 
 * This class will build a Trial Balance for the entire General Ledger
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class TrialBalance
{
    /**
     * @var LedgerContainer
     */
    protected $oContainer;
    
    
    /**
     * @var DateTime
     */ 
    protected $oTrialDate;
    
    
    
    protected function getEntrySource($bUseAggSource)
    {
        $oContainer     = $this->getContainer();
        $oConnection    = $oContainer->getDatabaseAdapter();
        $aTableMap      = $oContainer->getTableMap();
        $oTrialDate     = $this->getTrialDate();
        
        if(true === $bUseAggSource) {
            $oEntrySource  = new AggAllSource($oTrialDate,$oConnection,$aTableMap);
            
        } else {
            $oEntrySource  =  new EntrySource($oTrialDate,$oConnection,$aTableMap);
        }
        
        return $oEntrySource;
        
    }
    
    protected function getAccountTreeBuilder()
    {
        $oContainer     = $this->getContainer();
        $oConnection    = $oContainer->getDatabaseAdapter();
        $aTableMap      = $oContainer->getTableMap();
        $oLogger        = $oContainer->getAppLogger();
       
        # load the account info 
        $oEntrySource   = $this->getEntrySource();
        
        return new AccountTreeBuilder($oConnection, $oLogger,  $oEntrySource, $aTableMap);
        
    }
    
    protected function getBalanceGenerator()
    {
        return new BalanceGenerator($this->getAccountTreeBuilder()->buildAccountTree());
    }
    
    
    //--------------------------------------------------------------------------
    
    public function __construct(LedgerContainer $oContainer, DateTime $oTrialDate, $bUseAggSource = true)
    {
        $this->oContainer  = $oContainer;
        $this->oTrialDate  = $oTrialDate;
        
    }
    
    /**
     * Return a Trial Balance
     * 
     * @return array(LedgerBalance)
     */ 
    public function getTrialBalance()
    {
        return $this->getBalanceGenerator()->buildTrialBalance();
    }
    
    //--------------------------------------------------------------------------
    # Properties
    
    public function getContainer()
    {
        return $this->oContainer;
    }
    
    public function getTrialDate()
    {
        return $this->oTrialDate;
    }
    
}
/* End of User */