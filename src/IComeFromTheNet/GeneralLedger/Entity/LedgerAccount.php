<?php
namespace IComeFromTheNet\GeneralLedger\Entity;

use DateTime;
use IComeFromTheNet\GeneralLedger\Exception\LedgerException;


/**
  *  Represents a single account
  *
  *  Each account are part of a tree so have 1 parent and 1 child. 
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class LedgerAccount extends CommonEntity
{
    
    protected $aValidators = [
        'required'       => [['account_number','account_name','account_name_slug','is_left','is_right']]
        ,'slug'          => [['account_name_slug']]
        ,'lengthBetween' => [['account_number',1,25],['account_name_slug',1,50],['account_name_slug',1,50]]
        ,'different'     => [['is_left','is_right']]
        ,'boolean'       => [['hide_ui'],['is_left'],['is_right']]
    ];
   
    //--------------------------------------------------------------------
    # public properties
   
    public $iAccountID;
    
    public $sAccountNumber;
    
    public $sAccountName;
    
    public $sAccountNameSlug;
    
    public $bHideUI;
    
    public $bIsLeft;
    
    public $bIsRight;
   
   
    
    //-------------------------------------------------------------------
    # Database hooks
   
    
    protected function createNew($aDatabaseData)
    {
        $oGateway = $this->getTableGateway();
        $oLogger  = $this->getAppLogger();
        
        $bSuccess = $oGateway->insertQuery()
             ->start()
                ->addColumn('account_number',$aDatabaseData['account_number'])
                ->addColumn('account_name',$aDatabaseData['account_name'])
                ->addColumn('account_name_slug',$aDatabaseData['account_name_slug'])
                ->addColumn('hide_ui',$aDatabaseData['hide_ui'])
                ->addColumn('is_left',$aDatabaseData['is_left'])
                ->addColumn('is_right',$aDatabaseData['is_right'])
             ->end()
           ->insert(); 

        if($bSuccess) {
            $this->iAccountID = $oGateway->lastInsertId();
            
            $sMsg    = sprintf('Created new account %s at id %s',$aDatabaseData['account_name'], $this->iAccountID);
        } else {
            $this->aLastResult['result'] = false;
            $sMsg    = sprintf('Unable to create new account %s',$aDatabaseData['account_name']);
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
                ->addColumn('account_number',$aDatabaseData['account_number'])
                ->addColumn('account_name',$aDatabaseData['account_name'])
                ->addColumn('account_name_slug',$aDatabaseData['account_name_slug'])
                ->addColumn('hide_ui',$aDatabaseData['hide_ui'])
                ->addColumn('is_left',$aDatabaseData['is_left'])
                ->addColumn('is_right',$aDatabaseData['is_right'])
            ->where()
                ->andWhere('account_id = :iAccountId')
                ->setParameter(':iAccountId',$aDatabaseData['account_id'])
             ->end()
           ->update(); 

        if($bSuccess) {
            $sMsg    = sprintf('Updated account %s at id %s',$aDatabaseData['account_name'], $this->iAccountID);
        } else {
            $this->aLastResult['result'] = false;
            $sMsg    = sprintf('Unable to update account %s at id %s',$aDatabaseData['account_name'],$aDatabaseData['account_id']);
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
                ->where('account_id = :iAccountId')
                ->setParameter(':iAccountId',$aDatabaseData['account_id'])
             ->end()
           ->delete(); 

        if($bSuccess) {
            $sMsg    = sprintf('Removed account %s at id %s',$aDatabaseData['account_name'], $this->iAccountID);
        } else {
            $this->aLastResult['result'] = false;
            $sMsg    = sprintf('Unable to remove account account %s at id %s',$aDatabaseData['account_name'],$aDatabaseData['account_id']);
        }
        
        $this->aLastResult['result'] = $bSuccess;
        $this->aLastResult['msg']    = $sMsg;
        
        $oLogger->debug($sMsg);
         
        return $bSuccess; 
    }
    
    
    protected function getEntityId() 
    {
        return $this->iAccountID;
    }
   
}
/* End of Class */
