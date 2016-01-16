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
    
    public function __construct(LedgerContainer $oContainer, DateTime $oTrialDate, $iOrgUnit, $bUseAggSource = true)
    {
        $this->iOrgUnit = $iOrgUnit;
        
        parent::__construct($oContainer,$oTrialDate,$bUseAggSource);    
    }
    
    
    
    //--------------------------------------------------------------------------
    # Properties
    
    public function getOrgUnit()
    {
        return $this->iOrgUnit;
    }
    
    
}
/* End of File */ 