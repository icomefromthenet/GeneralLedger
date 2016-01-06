<?php
namespace IComeFromTheNet\GeneralLedger\Entity;

use DateTime;
use IComeFromTheNet\GeneralLedger\Exception\LedgerException;

/**
  *  Represent a Journal.
  *
  *  A Journal is the source of the accounring event that caused this transaction
  *  i.e. sales recepit, credit node
  * 
  *  A journal identified by a voucher number / journal number.
  * 
  *  A transaction will be linked to both a journal type and a voucher number
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class LedgerJournalType extends CommonEntity
{
    
    protected $aValidators = [
        'required'       => [['journal_name'],['journal_name_slug'],['hide_ui']]
        ,'slug'          => [['journal_name_slug']]
        ,'lengthBetween' => [['journal_name',1,50],['journal_name_slug',1,50]]
        ,'boolean'       => [['hide_ui']]
        
    ];
   
    //--------------------------------------------------------------------
    # public properties
    
    public $iJournalTypeID;
    
    public $sJournalName;
    
    public $sJournalNameSlug;
    
    public $bHideUI;
    
    
    
    //-------------------------------------------------------------------
    # Database hooks
   
    
    protected function createNew($aDatabaseData)
    {
        $oGateway = $this->getTableGateway();
        $oLogger  = $this->getAppLogger();
        
        $bSuccess = $oGateway->insertQuery()
             ->start()
                ->addColumn('journal_name',$aDatabaseData['journal_name'])
                ->addColumn('journal_name_slug',$aDatabaseData['journal_name_slug'])
                ->addColumn('hide_ui',$aDatabaseData['hide_ui'])
             ->end()
           ->insert(); 

        if($bSuccess) {
            $this->iJournalTypeID = $oGateway->lastInsertId();
            
            $sMsg    = sprintf('Created new ledger journal type %s',$aDatabaseData['journal_name']);
        } else {
            $this->aLastResult['result'] = false;
            $sMsg    = sprintf('Unable to create new ledger journal type %s',$aDatabaseData['journal_name']);
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
                ->addColumn('journal_name',$aDatabaseData['journal_name'])
                ->addColumn('journal_name_slug',$aDatabaseData['journal_name_slug'])
                ->addColumn('hide_ui',$aDatabaseData['hide_ui'])
            ->where()
                ->andWhere('journal_type_id = :iJournalTypeID')
                ->setParameter(':iJournalTypeID',$aDatabaseData['journal_type_id'])
             ->end()
           ->update(); 

        if($bSuccess) {
            $sMsg    = sprintf('Updated ledger journal type %s at id %s',$aDatabaseData['journal_name'], $aDatabaseData['journal_type_id']);
        } else {
            $this->aLastResult['result'] = false;
            $sMsg    = sprintf('Unable to update ledger journal type %s at id %s',$aDatabaseData['journal_name'],$aDatabaseData['journal_type_id']);
        }
        
        $this->aLastResult['result'] = $bSuccess;
        $this->aLastResult['msg']    = $sMsg;
        
        $oLogger->debug($sMsg);
         
        return $bSuccess; 
    }
    
    
    protected function deleteExisting($aDatabaseData)
    {
        $oGateway = $this->getTableGateway();
        $oLogger  = $this->getAppLogger();
        
        $bSuccess = $oGateway->deleteQuery()
             ->start()
                ->where('journal_type_id = :iJournalTypeID')
                ->setParameter(':iJournalTypeID',$aDatabaseData['journal_type_id'])
             ->end()
           ->delete(); 

        if($bSuccess) {
            $sMsg    = sprintf('Removed ledger journal type %s at id %s',$aDatabaseData['journal_name'], $aDatabaseData['journal_type_id']);
        } else {
            $this->aLastResult['result'] = false;
            $sMsg    = sprintf('Unable to ledger journal type %s at id %s',$aDatabaseData['journal_name'],$aDatabaseData['journal_type_id']);
        }
        
        $this->aLastResult['result'] = $bSuccess;
        $this->aLastResult['msg']    = $sMsg;
        
        $oLogger->debug($sMsg);
         
        return $bSuccess; 
    }
    
    
    protected function getEntityId() 
    {
        return $this->iJournalTypeID;
    }

    
    
    
}
/* End of Class */