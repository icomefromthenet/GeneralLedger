<?php
namespace IComeFromTheNet\GeneralLedger\Entity;

use DateTime;
use Psr\Log\LoggerInterface;
use DBALGateway\Builder\BuilderInterface;
use DBALGateway\Table\TableInterface;
use IComeFromTheNet\GeneralLedger\Exception\LedgerException;
use IComeFromTheNet\GeneralLedger\Entity\Account;

class CommonBuilder implements BuilderInterface
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
                $oEntity = new Account($this->oGateway,$this->oLogger);
                $oEntity->iAccountID        = $aData['account_id'];
                $oEntity->sAccountNumber    = $aData['account_number'];
                $oEntity->sAccountName      = $aData['account_name'];
                $oEntity->sAccountNameSlug  = $aData['account_name_slug'];
                $oEntity->bHideUI           = $aData['hide_ui'];
                $oEntity->bIsLeft           = $aData['is_left'];
                $oEntity->bIsRight          = $aData['is_right'];
            break;
            case self::MODE_TRANSACTION:
                $oEntity = new LedgerTransaction($this->oGateway,$this->oLogger);
                $oEntity->iTransactionID   = $aData['transaction_id'];
                $oEntity->iOrgUnitID       = $aData['org_unit_id'];
                $oEntity->oProcessingDate  = $aData['process_dt'];
                $oEntity->oOccuredDate     = $aData['occured_dt'];
                $oEntity->sVoucherNumber   = $aData['vouchernum'];
                $oEntity->iJournalTypeID   = $aData['journal_type_id'];
                $oEntity->iAdjustmentID    = $aData['adjustment_id'];
                $oEntity->iUserId          = $aData['user_id']; 
                
                
            break;
            case self::MODE_ENTRY:
                $oEntity = new LedgerEntry($this->oGateway,$this->oLogger);
                $oEntity->iEntryID        = $aData['entry_id'];
                $oEntity->iTransactionID  = $aData['transaction_id'];
                $oEntity->iAccountID      = $aData['account_id'];
                $oEntity->fMovement       = $aData['movement'];
            
            
            break;
            case self::MODE_ORGUNIT:
                 $oEntity = new LedgerOrganisationUnit($this->oGateway,$this->oLogger);
            
            break;
            case self::MODE_USER:
                 $oEntity = new LedgerUser($this->oGateway,$this->oLogger);
            
            break;
            case self::MODE_JTYPE:
                 $oEntity = new LedgerJournalType($this->oGateway,$this->oLogger);
            
            break;
            case self::MODE_AGG_ENTRY:
                 $oEntity = new LedgerAggEntry($this->oGateway,$this->oLogger);
                
            break;
            case self::MODE_AGG_ORG:
                 $oEntity = new LedgerAggOrg($this->oGateway,$this->oLogger);
            
            break;
            case self::MODE_AGG_USER:
                 $oEntity = new LedgerAggUser($this->oGateway,$this->oLogger);
                 
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
                $aData['user_id']         = $oEntity->iUserId; 
            
            break;
            case self::MODE_ENTRY:
                
                $aData['entry_id']        = $oEntity->iEntryID;
                $aData['transaction_id']  = $oEntity->iTransactionID;
                $aData['account_id']      = $oEntity->iAccountID;
                $aData['movement']        = $oEntity->fMovement;
                
            break;
            case self::MODE_ORGUNIT:
            
            break;
            case self::MODE_USER:
            
            break;
            case self::MODE_JTYPE:
            
            break;
            case self::MODE_AGG_ENTRY:
            
            break;
            case self::MODE_AGG_ORG:
            
            break;
            case self::MODE_AGG_USER:
            
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
