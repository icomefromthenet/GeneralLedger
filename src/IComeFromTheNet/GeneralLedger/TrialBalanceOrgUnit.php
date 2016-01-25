<?php
namespace IComeFromTheNet\GeneralLedger;

use DateTime;
use IComeFromTheNet\GeneralLedger\TrialBalance\EntryOrgSource;
use IComeFromTheNet\GeneralLedger\TrialBalance\AggOrgSource;


/**
 * Will Build a Trial Balance for a single Org Unit.
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class TrialBalanceOrgUnit extends TrialBalance
{
    
    /**
     * @var integer the database id of the Org Unit
     */ 
    protected $iOrgUnit;
    
    /**
     * Get the entry datasource
     * 
     * @param boolean  $bUseAggSource    Use the Agg source or the default source
     * @return mixed   AggOrgSource | EntryOrgSource
     * 
     */ 
    protected function getEntrySource($bUseAggSource)
    {
        $oContainer     = $this->getContainer();
        $oConnection    = $oContainer->getDatabaseAdapter();
        $aTableMap      = $oContainer->getTableMap();
        $oTrialDate     = $this->getTrialDate();
        $iOrgUnit       = $this->getOrgUnit();
        
        if(true === $bUseAggSource) {
            $oEntrySource  = new AggOrgSource($oTrialDate,$oConnection,$aTableMap,$iOrgUnit);
            
        } else {
            $oEntrySource  =  new EntryOrgSource($oTrialDate,$oConnection,$aTableMap,$iOrgUnit);
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
     * @param integer           $iOrgUnit       The user database id from ledger_org_unit
     * @param boolean           $bUseAggSource  Use the Agg table ledger_daily_user or the ledger_entry
     * 
     */
    public function __construct(LedgerContainer $oContainer, DateTime $oTrialDate, $iOrgUnit, $bUseAggSource = true)
    {
        $this->iOrgUnit = $iOrgUnit;
        
        parent::__construct($oContainer,$oTrialDate,$bUseAggSource);    
    }
    
    
    
    //--------------------------------------------------------------------------
    # Properties
    
    /**
     * Gets the organisation unit database id
     * 
     * @return integer The database id from ledger_org_unit
     */ 
    public function getOrgUnit()
    {
        return $this->iOrgUnit;
    }
    
    
}
/* End of File */ 