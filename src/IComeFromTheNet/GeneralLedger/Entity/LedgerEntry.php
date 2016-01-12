<?php
namespace IComeFromTheNet\GeneralLedger\Entity;

use DateTime;
use IComeFromTheNet\GeneralLedger\Exception\LedgerException;

/**
  *  Represent an Ledger entry.
  *
  *  Each entry is bound to a ledger transaction
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class LedgerEntry extends CommonEntity
{
   
   protected $aValidators = [
        'required'   => [['transaction_id'],['account_id'],['movement']]
        ,'integer'   => [['entry_id'],['transaction_id'],['account_id']]
        ,'numeric'   => [['movement']]
        
    ];
   
    //--------------------------------------------------------------------
    # public properties
    
    public $iEntryID;
    
    public $iTransactionID;
    
    public $iAccountID;
    
    public $fMovement;
    
    
    
    //-------------------------------------------------------------------
    # Database hooks
   
    
    protected function createNew($aDatabaseData)
    {
        $oGateway = $this->getTableGateway();
        $oLogger  = $this->getAppLogger();
        
        $bSuccess = $oGateway->insertQuery()
             ->start()
                ->addColumn('transaction_id',$aDatabaseData['transaction_id'])
                ->addColumn('account_id',$aDatabaseData['account_id'])
                ->addColumn('movement',$aDatabaseData['movement'])
             ->end()
           ->insert(); 

        if($bSuccess) {
            $this->iEntryID = $oGateway->lastInsertId();
            
            $sMsg    = sprintf('Created new ledger entry for transaction at id %s for account at id %s',$aDatabaseData['transaction_id'],$aDatabaseData['account_id']);
        } else {
            $this->aLastResult['result'] = false;
            $sMsg    = sprintf('Unable to create new ledger entry for transaction at id %s at account at id',$aDatabaseData['transaction_id'],$aDatabaseData['account_id']);
        }
        
        $this->aLastResult['result'] = $bSuccess;
        $this->aLastResult['msg']    = $sMsg;
        
        $oLogger->debug($sMsg);
         
        return $bSuccess; 
             
    }
    
    
    protected function updateExisting($aDatabaseData)
    {
        throw new LedgerException('Updateis not support for ledger transactions');
    }
    
    
    protected function deleteExisting($aDatabaseData)
    {
        throw new LedgerException('Delete is not support for ledger transactions');
    }
    
    
    protected function getEntityId() 
    {
        return $this->iEntryID;
    }
    
   
}
/* End of Class */
