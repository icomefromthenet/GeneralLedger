<?php
namespace IComeFromTheNet\GeneralLedger\Entity;

use DateTime;
use Psr\Log\LoggerInterface;
use DBALGateway\Builder\AliasBuilder;
use DBALGateway\Table\TableInterface;
use IComeFromTheNet\GeneralLedger\Exception\LedgerException;

class CommonBuilder extends AliasBuilder
{
 
    const MODE_ACCOUNT      = 'account';
    const MODE_TRANSACTION  = 'transaction';
    const MODE_ENTRY        = 'entity';
    const MODE_ORGUNIT      = 'orgunit';
    const MODE_USER         = 'user';
    const MODE_JTYPE        = 'jtype';
    const MODE_AGG_ENTRY    = 'agg';
    const MODE_AGG_ORG      = 'agg_org';
    const MODE_AGG_USER     = 'agg_user';
 
 
    protected $sMode;

    protected $oGateway;
    
    protected $oLogger;


    public function __construct($sMode)
    {
        $sMode = strtolower($sMode);
        
        if(false === in_array($sMode,array(self::MODE_ACCOUNT
                                        , self::MODE_TRANSACTION
                                        , self::MODE_ENTRY
                                        , self::MODE_ORGUNIT
                                        , self::MODE_USER
                                        , self::MODE_JTYPE
                                        , self::MODE_AGG_ENTRY
                                        , self::MODE_AGG_ORG
                                        , self::MODE_AGG_USER))){
            throw new LedgerException($sMode." is not supported");
        }
        
        $this->sMode         = $sMode;
    }

    
    /**
      *  Convert data array into entity
      *
      *  @return mixed
      *  @param array $data
      *  @access public
      */
    public function build($aData)
    {
        $oEntity = array();
       
        switch($this->sMode) {
            case self::MODE_ACCOUNT:
                $oEntity = new LedgerAccount($this->oGateway,$this->oLogger);
                $oEntity->iAccountID        = $this->getField($aData,'account_id',$this->getTableQueryAlias());
                $oEntity->sAccountNumber    = $this->getField($aData,'account_number',$this->getTableQueryAlias());
                $oEntity->sAccountName      = $this->getField($aData,'account_name',$this->getTableQueryAlias());
                $oEntity->sAccountNameSlug  = $this->getField($aData,'account_name_slug',$this->getTableQueryAlias());
                $oEntity->bHideUI           = $this->getField($aData,'hide_ui',$this->getTableQueryAlias());
                $oEntity->bIsLeft           = $this->getField($aData,'is_left',$this->getTableQueryAlias());
                $oEntity->bIsRight          = $this->getField($aData,'is_right',$this->getTableQueryAlias());
            break;
            case self::MODE_TRANSACTION:
                $oEntity = new LedgerTransaction($this->oGateway,$this->oLogger);
                $oEntity->iTransactionID   = $this->getField($aData,'transaction_id',$this->getTableQueryAlias());
                $oEntity->iOrgUnitID       = $this->getField($aData,'org_unit_id',$this->getTableQueryAlias());
                $oEntity->oProcessingDate  = $this->getField($aData,'process_dt',$this->getTableQueryAlias());
                $oEntity->oOccuredDate     = $this->getField($aData,'occured_dt',$this->getTableQueryAlias());
                $oEntity->sVoucherNumber   = $this->getField($aData,'vouchernum',$this->getTableQueryAlias());
                $oEntity->iJournalTypeID   = $this->getField($aData,'journal_type_id',$this->getTableQueryAlias());
                $oEntity->iAdjustmentID    = $this->getField($aData,'adjustment_id',$this->getTableQueryAlias());
                $oEntity->iUserID          = $this->getField($aData,'user_id',$this->getTableQueryAlias()); 
                
                
            break;
            case self::MODE_ENTRY:
                $oEntity = new LedgerEntry($this->oGateway,$this->oLogger);
                $oEntity->iEntryID        = $this->getField($aData,'entry_id',$this->getTableQueryAlias());
                $oEntity->iTransactionID  = $this->getField($aData,'transaction_id',$this->getTableQueryAlias());
                $oEntity->iAccountID      = $this->getField($aData,'account_id',$this->getTableQueryAlias());
                $oEntity->fMovement       = $this->getField($aData,'movement',$this->getTableQueryAlias());
            
            
            break;
            case self::MODE_ORGUNIT:
                $oEntity = new LedgerOrganisationUnit($this->oGateway,$this->oLogger);
                $oEntity->iOrgUnitID        = $this->getField($aData,'org_unit_id',$this->getTableQueryAlias());
                $oEntity->sOrgUnitName      = $this->getField($aData,'org_unit_name',$this->getTableQueryAlias());
                $oEntity->sOrgunitNameSlug  = $this->getField($aData,'org_unit_name_slug',$this->getTableQueryAlias());
                $oEntity->bHideUI           = $this->getField($aData,'hide_ui',$this->getTableQueryAlias());
                
            break;
            case self::MODE_USER:
                $oEntity = new LedgerUser($this->oGateway,$this->oLogger);
            
                $oEntity->iUserID       =  $this->getField($aData,'user_id',$this->getTableQueryAlias());
                $oEntity->sExternalGUID =  $this->getField($aData,'external_guid',$this->getTableQueryAlias());
                $oEntity->oRegoDate     =  $this->getField($aData,'rego_date',$this->getTableQueryAlias());
            
            break;
            case self::MODE_JTYPE:
                $oEntity = new LedgerJournalType($this->oGateway,$this->oLogger);
            
                $oEntity->iJournalTypeID    = $this->getField($aData,'journal_type_id',$this->getTableQueryAlias());
                $oEntity->sJournalName      = $this->getField($aData,'journal_name',$this->getTableQueryAlias());
                $oEntity->sJournalNameSlug  = $this->getField($aData,'journal_name_slug',$this->getTableQueryAlias());
                $oEntity->bHideUI           = $this->getField($aData,'hide_ui',$this->getTableQueryAlias());
            
            break;
            case self::MODE_AGG_ENTRY:
                $oEntity = new LedgerAggEntry($this->oGateway,$this->oLogger);
                 
                $oEntity->oProcessingDate = $this->getField($aData,'process_dt',$this->getTableQueryAlias());
                $oEntity->iAccountID      = $this->getField($aData,'account_id',$this->getTableQueryAlias());
                $oEntity->fBalance        = $this->getField($aData,'balance',$this->getTableQueryAlias());
                 
                
            break;
            case self::MODE_AGG_ORG:
                $oEntity = new LedgerAggOrg($this->oGateway,$this->oLogger);
                
                $oEntity->oProcessingDate = $this->getField($aData,'process_dt',$this->getTableQueryAlias());
                $oEntity->iAccountID      = $this->getField($aData,'account_id',$this->getTableQueryAlias());
                $oEntity->fBalance        = $this->getField($aData,'balance',$this->getTableQueryAlias());
                $oEntity->iOrgUnitID      = $this->getField($aData,'org_unit_id',$this->getTableQueryAlias());
                
            break;
            case self::MODE_AGG_USER:
                $oEntity = new LedgerAggUser($this->oGateway,$this->oLogger);
                 
                $oEntity->oProcessingDate = $this->getField($aData,'process_dt',$this->getTableQueryAlias());
                $oEntity->iAccountID      = $this->getField($aData,'account_id',$this->getTableQueryAlias());
                $oEntity->fBalance        = $this->getField($aData,'balance',$this->getTableQueryAlias());
                $oEntity->iUserID         = $this->getField($aData,'user_id',$this->getTableQueryAlias());
                 
            break;
            default : throw new LedgerException($this->sMode." is not supported");
        }
        
        return $oEntity;

    }

    /**
      *  Convert and entity into a data array
      *
      *  @return array
      *  @access public
      */
    public function demolish($oEntity)
    {
        $aData = array();
       
        switch($this->sMode) {
            case self::MODE_ACCOUNT:
                
                $aData['account_id']        = $oEntity->iAccountID;
                $aData['account_number']    = $oEntity->sAccountNumber;
                $aData['account_name']      = $oEntity->sAccountName;
                $aData['account_name_slug'] = $oEntity->sAccountNameSlug;
                $aData['hide_ui']           = $oEntity->bHideUI;
                $aData['is_left']           = $oEntity->bIsLeft;
                $aData['is_right']          = $oEntity->bIsRight;
                
            break;
             case self::MODE_TRANSACTION:
            
                $aData['transaction_id']  = $oEntity->iTransactionID;
                $aData['org_unit_id']     = $oEntity->iOrgUnitID;
                $aData['process_dt']      = $oEntity->oProcessingDate;
                $aData['occured_dt']      = $oEntity->oOccuredDate;
                $aData['vouchernum']      = $oEntity->sVoucherNumber;
                $aData['journal_type_id'] = $oEntity->iJournalTypeID;
                $aData['adjustment_id']   = $oEntity->iAdjustmentID;
                $aData['user_id']         = $oEntity->iUserID; 
            
            break;
            case self::MODE_ENTRY:
                
                $aData['entry_id']        = $oEntity->iEntryID;
                $aData['transaction_id']  = $oEntity->iTransactionID;
                $aData['account_id']      = $oEntity->iAccountID;
                $aData['movement']        = $oEntity->fMovement;
                
            break;
            case self::MODE_ORGUNIT:
            
                $aData['org_unit_id']           = $oEntity->iOrgUnitID;
                $aData['org_unit_name']         = $oEntity->sOrgUnitName;
                $aData['org_unit_name_slug']    = $oEntity->sOrgunitNameSlug;
                $aData['hide_ui']               = $oEntity->bHideUI;
            
            break;
            case self::MODE_USER:
                
                $aData['user_id']           = $oEntity->iUserID;
                $aData['external_guid']     = $oEntity->sExternalGUID;
                $aData['rego_date']         = $oEntity->oRegoDate;
                
            break;
            case self::MODE_JTYPE:
            
                $aData['journal_type_id']   = $oEntity->iJournalTypeID;
                $aData['journal_name']      = $oEntity->sJournalName;
                $aData['journal_name_slug'] = $oEntity->sJournalNameSlug;
                $aData['hide_ui']           = $oEntity->bHideUI;
            
            break;
            case self::MODE_AGG_ENTRY:
            
                $aData['process_dt']   = $oEntity->oProcessingDate;
                $aData['account_id']   = $oEntity->iAccountID;
                $aData['balance']      = $oEntity->fBalance;
            
            break;
            case self::MODE_AGG_ORG:
                
                $aData['process_dt']   = $oEntity->oProcessingDate;
                $aData['account_id']   = $oEntity->iAccountID;
                $aData['balance']      = $oEntity->fBalance;
                $aData['org_unit_id']  = $oEntity->iOrgUnitID;
            
            
            break;
            case self::MODE_AGG_USER:
            
                $aData['process_dt']   = $oEntity->oProcessingDate;
                $aData['account_id']   = $oEntity->iAccountID;
                $aData['balance']      = $oEntity->fBalance;
                $aData['user_id']      = $oEntity->iUserID;
            
            break;
            default : throw new LedgerException($this->sMode." is not supported");
        }
        
        return $aData;
    }
    
    
   public function setGateway(TableInterface $oGateway)
   {
        $this->oGateway = $oGateway;
   }
   
   public function setLogger(LoggerInterface $oLogger)
   {
       $this->oLogger  = $oLogger;
   }
    
    
}

/* End of Class */

