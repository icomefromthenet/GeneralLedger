<?php
namespace IComeFromTheNet\GeneralLedger\Entity;

use DateTime;
use IComeFromTheNet\GeneralLedger\Exception\LedgerException;

/**
  *  Represent a ledger user, these units are used
  *  to link transaction to a single appuser or a customer.
  *  
  *  Assume that these users can be grouped into OrgUnits
  * 
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class LedgerUser extends CommonEntity
{
    
    protected $aValidators = [
        'required'       => [['external_guid'],['rego_date']]
        ,'instanceof'    => [['rego_date','DateTime']]
        ,'lengthBetween' => [['external_guid',1,36]]
    ];
   
    //--------------------------------------------------------------------
    # public properties
   
    public $iUserID;
    
    public $sExternalGUID;
    
    public $oRegoDate;
    
   
    
    //-------------------------------------------------------------------
    # Database hooks
   
    
    protected function createNew($aDatabaseData)
    {
        $oGateway = $this->getTableGateway();
        $oLogger  = $this->getAppLogger();
        
        $bSuccess = $oGateway->insertQuery()
            ->start()
                ->addColumn('external_guid',$aDatabaseData['external_guid'])
                ->addColumn('rego_date',$aDatabaseData['rego_date'])
            ->end()
           ->insert(); 

        if($bSuccess) {
            $this->iUserID = $oGateway->lastInsertId();
            
            $sMsg    = sprintf('Created new ledger user %s',$aDatabaseData['external_guid']);
        } else {
            $this->aLastResult['result'] = false;
            $sMsg    = sprintf('Unable to create new ledger user %s',$aDatabaseData['external_guid']);
        }
        
        $this->aLastResult['result'] = $bSuccess;
        $this->aLastResult['msg']    = $sMsg;
        
        $oLogger->debug($sMsg);
         
        return $bSuccess; 
             
    }
    
    
    protected function updateExisting($aDatabaseData)
    {
        throw new LedgerException('Not supported');
    }
    
    
    protected function deleteExisting($aDatabaseData)
    {
        $oGateway = $this->getTableGateway();
        $oLogger  = $this->getAppLogger();
        
        $bSuccess = $oGateway->deleteQuery()
            ->start()
                ->where('user_id = :iUserID')
                ->setParameter(':iUserID',$aDatabaseData['user_id'])
             ->end()
           ->delete(); 

        if($bSuccess) {
            $sMsg    = sprintf('Removed ledger user at id %s',$aDatabaseData['user_id']);
        } else {
            $this->aLastResult['result'] = false;
            $sMsg    = sprintf('Unable to ledger user at id %s',$aDatabaseData['user_id']);
        }
        
        $this->aLastResult['result'] = $bSuccess;
        $this->aLastResult['msg']    = $sMsg;
        
        $oLogger->debug($sMsg);
         
        return $bSuccess; 
    }
    
    
    protected function getEntityId() 
    {
        return $this->iUserID;
    }
   
    
    
}
/* End of Class */
