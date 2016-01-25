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
 * A Trial Balance is a audit function where which will check if the ledger is in balance,
 * meaning all debits equals credits. It is also used to list account balances for display in a UI.
 * 
 * Accounts on the left are known as debit accounts.
 * Accounts on the right are known as credit accounts.
 * 
 * This class will build a Trial Balance for the General Ledger
 * 
 * A trial balance is run upto a date, this date must be supplied.
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
    
    /**
     * @var boolean
     */ 
    protected $bUseAggSource;
    
    
    /**
     * Get the entry datasource
     * 
     * @param boolean  $bUseAggSource    Use the Agg source or the default source
     * @return mixed   AggAllSource | EntrySource
     * 
     */ 
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
    
    /**
     * Return a new instance of AccountTreeBuilder which is a data structure
     * that holds the Chart of Accounts. 
     * 
     * @return AccountTreeBuilder 
     */ 
    protected function getAccountTreeBuilder()
    {
        $oContainer     = $this->getContainer();
        $oConnection    = $oContainer->getDatabaseAdapter();
        $aTableMap      = $oContainer->getTableMap();
        $oLogger        = $oContainer->getAppLogger();
       
        # load the account info 
        $oEntrySource   = $this->getEntrySource($this->getUseAggSource());
        
        return new AccountTreeBuilder($oConnection, $oLogger,  $oEntrySource, $aTableMap);
        
    }
    
    /**
     * Return the trial balance generator which converts the Chart of Accounts Tree 
     * into a Trial Balance.
     * 
     * @return BalanceGenerator
     */ 
    protected function getBalanceGenerator()
    {
        return new BalanceGenerator($this->getAccountTreeBuilder()->buildAccountTree());
    }
    
    
    //--------------------------------------------------------------------------
    
     /**
     * Class constructor
     *  
     * @param LedgerContainer   $oContainer     The service DI container
     * @param DateTime          $oTrialDate     The date to run the trail balance too.
     * @param boolean           $bUseAggSource  Use the Agg table ledger_daily_user or the ledger_entry
     * 
     */
    public function __construct(LedgerContainer $oContainer, DateTime $oTrialDate, $bUseAggSource = true)
    {
        $this->oContainer  = $oContainer;
        $this->oTrialDate  = $oTrialDate;
        $this->bUseAggSource = $bUseAggSource;
        
    }
    
    /**
     * Return a Trial Balance which a collection of LedgerBalances
     * 
     * @return array(LedgerBalance)
     */ 
    public function getTrialBalance()
    {
        return $this->getBalanceGenerator()->buildTrialBalance();
    }
    
    //--------------------------------------------------------------------------
    # Properties
    
    /**
     * Return the lib Service Container
     * 
     * @return LedgerContainer
     */ 
    public function getContainer()
    {
        return $this->oContainer;
    }
    
    /**
     * Fetch the assigned trial balance date.
     * 
     * @return DateTime the trial balance date
     */ 
    public function getTrialDate()
    {
        return $this->oTrialDate;
    }
    
    /**
     * Return the Agg Source option
     * 
     * @return boolean true if use one of the agg tables
     */ 
    public function getUseAggSource()
    {
        return $this->bUseAggSource;
    }
    
}
/* End of User */