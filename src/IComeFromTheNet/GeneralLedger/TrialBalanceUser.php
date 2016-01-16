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
class TrialBalanceOrgUnit extends TrialBalance
{
    
    /**
     * @var integer the database id of the Org Unit
     */ 
    protected $iUser;
    
    
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
    
    public function __construct(LedgerContainer $oContainer, DateTime $oTrialDate, $iUser, $bUseAggSource = true)
    {
        $this->iUser = $iUser;
        
        parent::__construct($oContainer,$oTrialDate,$bUseAggSource);    
    }
    
    
    
    //--------------------------------------------------------------------------
    # Properties
    
    public function getUser()
    {
        return $this->iUser;
    }
    
    
}
/* End of File */ 