<?php
namespace IComeFromTheNet\GeneralLedger\Entity;

use DateTime;
use IComeFromTheNet\GeneralLedger\Exception\LedgerException;

/**
  *  Represent a Organisation Unit, these units are used
  *  to provide logical groups to ledger transactions.
  *
  *  Accounts track the what , organisation unit can track a group of who.
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class LedgerOrganisationUnit extends CommonEntity
{
    
    protected $aValidators = [
        'required'      => [['org_unit_name'],['org_unit_name_slug'],['hide_ui']]
        ,'slug'         => [['org_unit_name_slug']]
        ,'lengthBetween'=> [['org_unit_name',1,50],['org_unit_name_slug',1,50]]
        ,'boolean'      => [['hide_ui']]
    ];
   
    //--------------------------------------------------------------------
    # public properties
   
    public $iOrgUnitID;
    
    public $sOrgUnitName;
    
    public $sOrgunitNameSlug;
    
    public $bHideUI;
    
   
    
    //-------------------------------------------------------------------
    # Database hooks
   
    
    protected function createNew($aDatabaseData)
    {
        $oGateway = $this->getTableGateway();
        $oLogger  = $this->getAppLogger();
        
        $bSuccess = $oGateway->insertQuery()
            ->start()
                ->addColumn('org_unit_name',$aDatabaseData['org_unit_name'])
                ->addColumn('org_unit_name_slug',$aDatabaseData['org_unit_name_slug'])
                ->addColumn('hide_ui',$aDatabaseData['hide_ui'])
            ->end()
           ->insert(); 

        if($bSuccess) {
            $this->iOrgUnitID = $oGateway->lastInsertId();
            
            $sMsg    = sprintf('Created new organisation unit %s',$aDatabaseData['org_unit_name']);
        } else {
            $this->aLastResult['result'] = false;
            $sMsg    = sprintf('Unable to create new organisation unit %s',$aDatabaseData['org_unit_name']);
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
                ->addColumn('org_unit_name',$aDatabaseData['org_unit_name'])
                ->addColumn('org_unit_name_slug',$aDatabaseData['org_unit_name_slug'])
                ->addColumn('hide_ui',$aDatabaseData['hide_ui'])
            ->where()
                ->andWhere('org_unit_id = :iOrgUnitID')
                ->setParameter(':iOrgUnitID',$aDatabaseData['org_unit_id'])
             ->end()
           ->update(); 

        if($bSuccess) {
            $sMsg    = sprintf('Updated organisation unit %s at id %s',$aDatabaseData['org_unit_name'], $aDatabaseData['org_unit_id']);
        } else {
            $this->aLastResult['result'] = false;
            $sMsg    = sprintf('Unable to update organisation unit %s at id %s',$aDatabaseData['org_unit_name'],$aDatabaseData['org_unit_id']);
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
                ->where('org_unit_id = :iOrgUnitID')
                ->setParameter(':iOrgUnitID',$aDatabaseData['org_unit_id'])
             ->end()
           ->delete(); 

        if($bSuccess) {
            $sMsg    = sprintf('Removed organisation unit %s at id %s',$aDatabaseData['org_unit_name'], $aDatabaseData['org_unit_id']);
        } else {
            $this->aLastResult['result'] = false;
            $sMsg    = sprintf('Unable to remove organisation unit %s at id %s',$aDatabaseData['org_unit_name'],$aDatabaseData['org_unit_id']);
        }
        
        $this->aLastResult['result'] = $bSuccess;
        $this->aLastResult['msg']    = $sMsg;
        
        $oLogger->debug($sMsg);
         
        return $bSuccess; 
    }
    
    
    protected function getEntityId() 
    {
        return $this->iOrgUnitID;
    }
   
    
    
}
/* End of Class */
