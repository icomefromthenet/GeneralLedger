<?php
namespace IComeFromTheNet\GeneralLedger\Entity;

use DateTime;
use IComeFromTheNet\GeneralLedger\Exception\LedgerException;

/**
  *  Ledger Transaction
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class LedgerTransaction extends CommonEntity
{
    
    protected $aValidators = [
        'required'   => [['process_dt'],['occured_dt'],['user_id'],['org_unit_id']]
        ,'length'    => [['vouchernum',0,100]]
        ,'alphaNum'  => [['vouchernum']]
        ,'integer'   => [['transaction_id'],['org_unit_id'],['journal_type_id'],['adjustment_id'],['user_id']]
        //,'instanceOf' => [['process_dt','DateTime'],['occured_dt','DateTime']]
    ];
   
    //--------------------------------------------------------------------
    # public properties
    
    public $iTransactionID;
    
    public $iOrgUnitID;
    
    public $oProcessingDate;
    
    public $oOccuredDate;
    
    public $sVoucherNumber;
    
    public $iJournalTypeID;
    
    public $iAdjustmentID;
    
    public $iUserID;
    
    
    //-------------------------------------------------------------------
    # Database hooks
   
    
    protected function createNew($aDatabaseData)
    {
        $oGateway = $this->getTableGateway();
        $oLogger  = $this->getAppLogger();
        
        $bSuccess = $oGateway->insertQuery()
             ->start()
                ->addColumn('org_unit_id',$aDatabaseData['org_unit_id'])
                ->addColumn('process_dt',$aDatabaseData['process_dt'])
                ->addColumn('occured_dt',$aDatabaseData['occured_dt'])
                ->addColumn('vouchernum',$aDatabaseData['vouchernum'])
                ->addColumn('journal_type_id',$aDatabaseData['journal_type_id'])
                ->addColumn('adjustment_id',$aDatabaseData['adjustment_id'])
                ->addColumn('user_id',$aDatabaseData['user_id'])
             ->end()
           ->insert(); 

        if($bSuccess) {
            $this->iTransactionID = $oGateway->lastInsertId();
            
            $sMsg    = sprintf('Created new ledger transaction at voucher %s',$aDatabaseData['vouchernum']);
        } else {
            $this->aLastResult['result'] = false;
            $sMsg    = sprintf('Unable to create new ledger transaction with voucher %s',$aDatabaseData['vouchernum']);
        }
        
        $this->aLastResult['result'] = $bSuccess;
        $this->aLastResult['msg']    = $sMsg;
        
        $oLogger->debug($sMsg);
         
        return $bSuccess; 
             
    }
    
    
    protected function updateExisting($aDatabaseData)
    {
        $oGateway = $this->getTableGateway();
        $oLogger  = $this->getAppLogger();
        
        $bSuccess = $oGateway->updateQuery()
             ->start()
                 ->addColumn('adjustment_id',$aDatabaseData['adjustment_id'])
            ->where()
                ->where('transaction_id= :iTransactionID')
                ->setParameter(':iTransactionID',$aDatabaseData['transaction_id'])
             ->end()
           ->update(); 

        if($bSuccess) {
            $sMsg    = sprintf('Updated ledger transaction at id %s with adjustment at id %s',$aDatabaseData['transaction_id'], $aDatabaseData['adjustment_id']);
        } else {
            $this->aLastResult['result'] = false;
            $sMsg    = sprintf('Unable to ledger transaction at id %s at id',$aDatabaseData['transaction_id']);
        }
        
        $this->aLastResult['result'] = $bSuccess;
        $this->aLastResult['msg']    = $sMsg;
        
        $oLogger->debug($sMsg);
         
        return $bSuccess; 
    }
    
    
    protected function deleteExisting($aDatabaseData)
    {
        throw new LedgerException('Delete is not support for ledger transactions');
    }
    
    
    protected function getEntityId() 
    {
        return $this->iTransactionID;
    }
   
    
}
/* End of Class */
