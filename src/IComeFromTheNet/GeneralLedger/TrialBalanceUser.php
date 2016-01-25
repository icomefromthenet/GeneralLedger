<?php
namespace IComeFromTheNet\GeneralLedger;

use DateTime;
use IComeFromTheNet\GeneralLedger\TrialBalance\EntryUserSource;
use IComeFromTheNet\GeneralLedger\TrialBalance\AggUserSource;


/**
 * Will Build a Trial Balance for a single User.
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class TrialBalanceUser extends TrialBalance
{
    
    /**
     * @var integer the database id of the Org Unit
     */ 
    protected $iUser;
    
    
    /**
     * Get the entry datasource
     * 
     * @param boolean  $bUseAggSource    Use the Agg source or the default source
     * @return mixed   AggUserSource | EntryUserSource
     * 
     */ 
    protected function getEntrySource($bUseAggSource)
    {
        $oContainer     = $this->getContainer();
        $oConnection    = $oContainer->getDatabaseAdapter();
        $aTableMap      = $oContainer->getTableMap();
        $oTrialDate     = $this->getTrialDate();
        $iUser          = $this->getUser();
        
        if(true === $bUseAggSource) {
            $oEntrySource  = new AggUserSource($oTrialDate,$oConnection,$aTableMap,$iUser);
            
        } else {
            $oEntrySource  =  new EntryUserSource($oTrialDate,$oConnection,$aTableMap,$iUser);
        }
        
        return $oEntrySource;
        
    }
    
    //--------------------------------------------------------------------------
    # Public Methods
    
    /**
     * Class constructor
     *  
     * @param LedgerContainer   $oContainer     The service DI container
     * @param DateTime          $oTrialDate     The date to run the trail balance too.
     * @param integer           $iUser          The user database id from ledger_user
     * @param boolean           $bUseAggSource  Use the Agg table ledger_daily_user or the ledger_entry
     * 
     */ 
    public function __construct(LedgerContainer $oContainer, DateTime $oTrialDate, $iUser, $bUseAggSource = true)
    {
        $this->iUser = $iUser;
        
        parent::__construct($oContainer,$oTrialDate,$bUseAggSource);    
    }
    
    
    
    //--------------------------------------------------------------------------
    # Properties
    
    /**
     * Return the user database id 
     * 
     * @return integer the user database id from ledger_user
     */ 
    public function getUser()
    {
        return $this->iUser;
    }
    
    
}
/* End of File */ 