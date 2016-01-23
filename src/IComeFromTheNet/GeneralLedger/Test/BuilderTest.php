<?php
namespace IComeFromTheNet\GeneralLedger\Test;

use DateTime;
use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use IComeFromTheNet\GeneralLedger\Test\Base\TestWithContainer;
use IComeFromTheNet\GeneralLedger\Entity\CommonBuilder;
use IComeFromTheNet\GeneralLedger\Entity\LedgerAccount;
use IComeFromTheNet\GeneralLedger\Entity\LedgerTransaction;
use IComeFromTheNet\GeneralLedger\Entity\LedgerEntry;
use IComeFromTheNet\GeneralLedger\Entity\LedgerOrganisationUnit;
use IComeFromTheNet\GeneralLedger\Entity\LedgerUser;
use IComeFromTheNet\GeneralLedger\Entity\LedgerJournalType;
use IComeFromTheNet\GeneralLedger\Entity\LedgerAggEntry;
use IComeFromTheNet\GeneralLedger\Entity\LedgerAggOrg;
use IComeFromTheNet\GeneralLedger\Entity\LedgerAggUser;


class BuilderTest extends TestWithContainer
{
   
    public function getDataSet()
    {
       return new ArrayDataSet([
           __DIR__.'/fixture/example-system.php',
        ]);
    }
    
    
    
    public function testAccountEntity()
    {
        $oContainer = $this->getContainer();
        $oLogger    = $oContainer->getAppLogger();
        $oGateway   = $oContainer->getGatewayCollection()
                                 ->getGateway('ledger_account');
      
        $oBuilder   = $oGateway->getEntityBuilder();
        
        $iAccountId = 1;
        $sAccountNumber = '1-0000';
        $sAccountName = 'Example Account A';
        $sAccountNameSlug = 'example_account_a';
        $bHideUi = false;
        $bIsLeft = false;
        $bIsRight = true;
    
        
        $aDatabase = array(
            'acc_account_id' => $iAccountId
            ,'acc_account_number' => $sAccountNumber
            ,'acc_account_name' => $sAccountName
            ,'acc_account_name_slug' => $sAccountNameSlug
            ,'acc_hide_ui' => $bHideUi
            ,'acc_is_left' => $bIsLeft
            ,'acc_is_right' => $bIsRight
        );
        
        $oEntity = new LedgerAccount($oGateway,$oLogger);
        
        $oEntity->iAccountID = $iAccountId;
        $oEntity->sAccountNumber = $sAccountNumber;
        $oEntity->sAccountName = $sAccountName;
        $oEntity->sAccountNameSlug = $sAccountNameSlug;
        $oEntity->bHideUI  = $bHideUi;
        $oEntity->bIsLeft  = $bIsLeft;
        $oEntity->bIsRight = $bIsRight;
        
        
        # test database to Entity Mapper        
        $oNewEntity = $oBuilder->build($aDatabase);
        
        $this->assertEquals($oNewEntity->iAccountID,$iAccountId);
        $this->assertEquals($oNewEntity->sAccountNumber,$sAccountNumber);
        $this->assertEquals($oNewEntity->sAccountName,$sAccountName);
        $this->assertEquals($oNewEntity->sAccountNameSlug,$sAccountNameSlug);
        $this->assertEquals($oNewEntity->bHideUI,$bHideUi);
        $this->assertEquals($oNewEntity->bIsLeft,$bIsLeft);
        $this->assertEquals($oNewEntity->bIsRight,$bIsRight);
    
        # test entity to database mapper
        $aNewDatabase = $oBuilder->demolish($oEntity);
        
        $this->assertEquals($aNewDatabase['account_id'],$iAccountId);
        $this->assertEquals($aNewDatabase['account_number'],$sAccountNumber);
        $this->assertEquals($aNewDatabase['account_name'],$sAccountName);
        $this->assertEquals($aNewDatabase['account_name_slug'],$sAccountNameSlug);
        $this->assertEquals($aNewDatabase['hide_ui'],$bHideUi);
        $this->assertEquals($aNewDatabase['is_left'],$bIsLeft);
        $this->assertEquals($aNewDatabase['is_right'],$bIsRight);
        
    }
    
    
    public function testTransactionEntity() 
    {
        $oContainer = $this->getContainer();
        $oLogger    = $oContainer->getAppLogger();
        $oGateway   = $oContainer->getGatewayCollection()
                                 ->getGateway('ledger_transaction');
      
        $oBuilder   = $oGateway->getEntityBuilder();
        
        $iTransactionId = 100;
        $iOrgUnitId     = 200;
        $oProcessingDate = new DateTime();
        $oOccuredDate   = new DateTime('now - 5 day');
        $sVoucherNum   = 'AB10000';
        $iJournalTypeId = 400;
        $iAdjustmentId  = 900;
        $iUserId        = 860;
        
        $aDatabase = array(
            'lt_transaction_id'    => $iTransactionId
            ,'lt_org_unit_id'      => $iOrgUnitId
            ,'lt_process_dt'       => $oProcessingDate
            ,'lt_occured_dt'       => $oOccuredDate
            ,'lt_vouchernum'       => $sVoucherNum
            ,'lt_journal_type_id'  => $iJournalTypeId
            ,'lt_adjustment_id'    => $iAdjustmentId
            ,'lt_user_id'          => $iUserId
            
        );
        
        $oEntity = new LedgerTransaction($oGateway,$oLogger);
        
        $oEntity->iTransactionID   = $iTransactionId;
        $oEntity->iOrgUnitID       = $iOrgUnitId;
        $oEntity->oProcessingDate  = $oProcessingDate;
        $oEntity->oOccuredDate     = $oOccuredDate;
        $oEntity->sVoucherNumber   = $sVoucherNum;
        $oEntity->iJournalTypeID   = $iJournalTypeId;
        $oEntity->iAdjustmentID    = $iAdjustmentId;
        $oEntity->iUserID          = $iUserId;


        # test database to Entity Mapper        
        $oNewEntity = $oBuilder->build($aDatabase);
        
        $this->assertEquals($oNewEntity->iTransactionID,$iTransactionId);
        $this->assertEquals($oNewEntity->iOrgUnitID,$iOrgUnitId);
        $this->assertEquals($oNewEntity->oProcessingDate,$oProcessingDate);
        $this->assertEquals($oNewEntity->oOccuredDate,$oOccuredDate);
        $this->assertEquals($oNewEntity->sVoucherNumber,$sVoucherNum);
        $this->assertEquals($oNewEntity->iJournalTypeID,$iJournalTypeId);
        $this->assertEquals($oNewEntity->iAdjustmentID,$iAdjustmentId);
        $this->assertEquals($oNewEntity->iUserID,$iUserId);

        # test entity to database mapper
        $aNewDatabase = $oBuilder->demolish($oEntity);
        
        $this->assertEquals($aNewDatabase['transaction_id'],$iTransactionId);
        $this->assertEquals($aNewDatabase['org_unit_id'],$iOrgUnitId);
        $this->assertEquals($aNewDatabase['process_dt'],$oProcessingDate);
        $this->assertEquals($aNewDatabase['occured_dt'],$oOccuredDate);
        $this->assertEquals($aNewDatabase['vouchernum'],$sVoucherNum);
        $this->assertEquals($aNewDatabase['journal_type_id'],$iJournalTypeId);
        $this->assertEquals($aNewDatabase['adjustment_id'],$iAdjustmentId);
        $this->assertEquals($aNewDatabase['user_id'],$iUserId);
         
         
        
    }
    
    
    public function testTransactionEntryEntity() 
    {
        $oContainer = $this->getContainer();
        $oLogger    = $oContainer->getAppLogger();
        $oGateway   = $oContainer->getGatewayCollection()
                                 ->getGateway('ledger_entry');
      
        $oBuilder   = $oGateway->getEntityBuilder();
        
        $iEntryId = 100;
        $iTransactionId = 200;
        $iAccountId = 500;
        $fMovement = 100.67;
        
        
        $aDatabase = array(
             'le_entry_id'       => $iEntryId
            ,'le_transaction_id' => $iTransactionId
            ,'le_account_id' => $iAccountId
            ,'le_movement'   => $fMovement
            
        );
        
        $oEntity = new LedgerEntry($oGateway,$oLogger);
        
        $oEntity->iEntryID        = $iEntryId;
        $oEntity->iTransactionID  = $iTransactionId;
        $oEntity->iAccountID      = $iAccountId;
        $oEntity->fMovement       = $fMovement;
        
        # test database to Entity Mapper        
        $oNewEntity = $oBuilder->build($aDatabase);
        
        $this->assertEquals($oNewEntity->iEntryID, $iEntryId);
        $this->assertEquals($oNewEntity->iTransactionID, $iTransactionId);
        $this->assertEquals($oNewEntity->iAccountID, $iAccountId);
        $this->assertEquals($oNewEntity->fMovement, $fMovement);

        # test entity to database mapper
        $aNewDatabase = $oBuilder->demolish($oEntity);
        
        $this->assertEquals($aNewDatabase['entry_id'], $iEntryId);
        $this->assertEquals($aNewDatabase['transaction_id'], $iTransactionId);
        $this->assertEquals($aNewDatabase['account_id'], $iAccountId);
        $this->assertEquals($aNewDatabase['movement'], $fMovement);
        
        
    }
    
    public function testOrgUnitEntity()
    {
        $oContainer = $this->getContainer();
        $oLogger    = $oContainer->getAppLogger();
        $oGateway   = $oContainer->getGatewayCollection()
                                 ->getGateway('ledger_org_unit');
      
        $oBuilder   = $oGateway->getEntityBuilder();
        
        $iOrgUnitId = 1;
        $sOrgUnitName = 'example org unit';
        $sOrgUnitNameSlug = 'example_org_unit';
        $bHideUi = true;
        
        $aDatabase = array(
             'lou_org_unit_id'    => $iOrgUnitId
            ,'lou_org_unit_name'  => $sOrgUnitName
            ,'lou_org_unit_name_slug' => $sOrgUnitNameSlug
            ,'lou_hide_ui'  => $bHideUi
            
        );
        
        $oEntity = new LedgerOrganisationUnit($oGateway,$oLogger);
        
        $oEntity->iOrgUnitID       = $iOrgUnitId;
        $oEntity->sOrgUnitName     = $sOrgUnitName;
        $oEntity->sOrgunitNameSlug = $sOrgUnitNameSlug;
        $oEntity->bHideUI          = $bHideUi;
        
        # test database to Entity Mapper        
        $oNewEntity = $oBuilder->build($aDatabase);
        
        $this->assertEquals($oNewEntity->iOrgUnitID,$iOrgUnitId);
        $this->assertEquals($oNewEntity->sOrgUnitName,$sOrgUnitName);
        $this->assertEquals($oNewEntity->sOrgunitNameSlug,$sOrgUnitNameSlug);
        $this->assertEquals($oNewEntity->bHideUI,$bHideUi);
        
        
        # test entity to database mapper
        $aNewDatabase = $oBuilder->demolish($oEntity);
        
        $this->assertEquals($aNewDatabase['org_unit_id'], $iOrgUnitId);
        $this->assertEquals($aNewDatabase['org_unit_name'], $sOrgUnitName);
        $this->assertEquals($aNewDatabase['org_unit_name_slug'], $sOrgUnitNameSlug);
        $this->assertEquals($aNewDatabase['hide_ui'], $bHideUi);
        
    }
    
    public function testUserEntity()
    {
        $oContainer = $this->getContainer();
        $oLogger    = $oContainer->getAppLogger();
        $oGateway   = $oContainer->getGatewayCollection()
                                 ->getGateway('ledger_user');
      
        $oBuilder   = $oGateway->getEntityBuilder();
        
        $iUserId = 1;
        $sExternalGUID = '1111-1111-1111-1111';
        $oRegoDate   = new DateTime();
        
        $aDatabase = array(
             'lu_user_id'       => $iUserId
            ,'lu_external_guid' => $sExternalGUID
            ,'lu_rego_date'     => $oRegoDate
        );
        
        $oEntity = new LedgerUser($oGateway,$oLogger);
        
        $oEntity->iUserID        = $iUserId;
        $oEntity->sExternalGUID  = $sExternalGUID;
        $oEntity->oRegoDate      = $oRegoDate;
        
        # test database to Entity Mapper        
        $oNewEntity = $oBuilder->build($aDatabase);
        
        $this->assertEquals($oNewEntity->iUserID,$iUserId);
        $this->assertEquals($oNewEntity->sExternalGUID,$sExternalGUID);
        $this->assertEquals($oNewEntity->oRegoDate,$oRegoDate);
    
        
        # test entity to database mapper
        $aNewDatabase = $oBuilder->demolish($oEntity);
        
        $this->assertEquals($aNewDatabase['user_id'], $iUserId);
        $this->assertEquals($aNewDatabase['external_guid'], $sExternalGUID);
        $this->assertEquals($aNewDatabase['rego_date'], $oRegoDate);
       
    }
    
    public function testJournalTypeEntity()
    {
        $oContainer = $this->getContainer();
        $oLogger    = $oContainer->getAppLogger();
        $oGateway   = $oContainer->getGatewayCollection()
                                 ->getGateway('ledger_journal_type');
      
        $oBuilder   = $oGateway->getEntityBuilder();
        
        $iJournalTypeId = 1;
        $sJournalName = 'example journal';
        $sJournalNameSlug = 'example_journal';
        $bHideUI = true;
        
        $aDatabase = array(
             'ljt_journal_type_id'   => $iJournalTypeId
            ,'ljt_journal_name'      => $sJournalName     
            ,'ljt_journal_name_slug' => $sJournalNameSlug
            ,'ljt_hide_ui'           => $bHideUI
        );
        
        $oEntity = new LedgerJournalType($oGateway,$oLogger);
        
        $oEntity->iJournalTypeID    = $iJournalTypeId;
        $oEntity->sJournalName      = $sJournalName;
        $oEntity->sJournalNameSlug  = $sJournalNameSlug;
        $oEntity->bHideUI           = $bHideUI;
        
        
        # test database to Entity Mapper        
        $oNewEntity = $oBuilder->build($aDatabase);
        
        $this->assertEquals($oNewEntity->iJournalTypeID,$iJournalTypeId);
        $this->assertEquals($oNewEntity->sJournalName,$sJournalName);
        $this->assertEquals($oNewEntity->sJournalNameSlug,$sJournalNameSlug);
        $this->assertEquals($oNewEntity->bHideUI,$bHideUI);
    
        
        # test entity to database mapper
        $aNewDatabase = $oBuilder->demolish($oEntity);
        
        $this->assertEquals($aNewDatabase['journal_type_id'], $iJournalTypeId);
        $this->assertEquals($aNewDatabase['journal_name'], $sJournalName);
        $this->assertEquals($aNewDatabase['journal_name_slug'], $sJournalNameSlug);
        $this->assertEquals($aNewDatabase['hide_ui'], $bHideUI);
    }
    
    public function testAggEntryEntity()
    {
        $oContainer = $this->getContainer();
        $oLogger    = $oContainer->getAppLogger();
        $oGateway   = $oContainer->getGatewayCollection()
                                 ->getGateway('ledger_daily');
      
        $oBuilder   = $oGateway->getEntityBuilder();
        
        $iAccountId     = 200;
        $oProcessingDate = new DateTime('now - 5 day');
        $fBalance       = 587.69;
        
        $aDatabase = array(
            'la_process_dt'  => $oProcessingDate
            ,'la_account_id' => $iAccountId
            ,'la_balance'    => $fBalance
        );
        
        $oEntity = new LedgerAggEntry($oGateway,$oLogger);
        
        $oEntity->oProcessingDate   = $oProcessingDate;
        $oEntity->iAccountID        = $iAccountId;
        $oEntity->fBalance          = $fBalance;
        
        
        # test database to Entity Mapper        
        $oNewEntity = $oBuilder->build($aDatabase);
        
        $this->assertEquals($oNewEntity->oProcessingDate,$oProcessingDate);
        $this->assertEquals($oNewEntity->iAccountID,$iAccountId);
        $this->assertEquals($oNewEntity->fBalance,$fBalance);
     
    
        
        # test entity to database mapper
        $aNewDatabase = $oBuilder->demolish($oEntity);
        
        $this->assertEquals($aNewDatabase['process_dt'], $oProcessingDate);
        $this->assertEquals($aNewDatabase['account_id'], $iAccountId);
        $this->assertEquals($aNewDatabase['balance'], $fBalance);
       
        
    }
    
    public function testAggUserEntity()
    {
        $oContainer = $this->getContainer();
        $oLogger    = $oContainer->getAppLogger();
        $oGateway   = $oContainer->getGatewayCollection()
                                 ->getGateway('ledger_daily_user');
      
        $oBuilder   = $oGateway->getEntityBuilder();
        
        $iAccountId      = 200;
        $oProcessingDate = new DateTime('now - 5 day');
        $fBalance        = 587.69;
        $iUserId         = 1;
        
        $aDatabase = array(
            'lau_process_dt'  => $oProcessingDate
            ,'lau_account_id' => $iAccountId
            ,'lau_balance'    => $fBalance
            ,'lau_user_id'    => $iUserId
        );
        
        $oEntity = new LedgerAggUser($oGateway,$oLogger);
        
        $oEntity->oProcessingDate   = $oProcessingDate;
        $oEntity->iAccountID        = $iAccountId;
        $oEntity->fBalance          = $fBalance;
        $oEntity->iUserID           = $iUserId;
        
        
        # test database to Entity Mapper        
        $oNewEntity = $oBuilder->build($aDatabase);
        
        $this->assertEquals($oNewEntity->oProcessingDate,$oProcessingDate);
        $this->assertEquals($oNewEntity->iAccountID,$iAccountId);
        $this->assertEquals($oNewEntity->fBalance,$fBalance);
        $this->assertEquals($oNewEntity->iUserID,$iUserId);
     
    
        
        # test entity to database mapper
        $aNewDatabase = $oBuilder->demolish($oEntity);
        
        $this->assertEquals($aNewDatabase['process_dt'], $oProcessingDate);
        $this->assertEquals($aNewDatabase['account_id'], $iAccountId);
        $this->assertEquals($aNewDatabase['balance'], $fBalance);
        $this->assertEquals($aNewDatabase['user_id'], $iUserId);
        
    }
    
    public function testAggOrgUnitEntity()
    {
        $oContainer = $this->getContainer();
        $oLogger    = $oContainer->getAppLogger();
        $oGateway   = $oContainer->getGatewayCollection()
                                 ->getGateway('ledger_daily_org');
      
        $oBuilder   = $oGateway->getEntityBuilder();
        
        $iAccountId      = 200;
        $oProcessingDate = new DateTime('now - 5 day');
        $fBalance        = 587.69;
        $iOrgUnitId     = 1;
        
        $aDatabase = array(
            'lao_process_dt'    => $oProcessingDate
            ,'lao_account_id'   => $iAccountId
            ,'lao_balance'      => $fBalance
            ,'lao_org_unit_id'  => $iOrgUnitId
        );
        
        $oEntity = new LedgerAggUser($oGateway,$oLogger);
        
        $oEntity->oProcessingDate   = $oProcessingDate;
        $oEntity->iAccountID        = $iAccountId;
        $oEntity->fBalance          = $fBalance;
        $oEntity->iOrgUnitID        = $iOrgUnitId;
        
        
        # test database to Entity Mapper        
        $oNewEntity = $oBuilder->build($aDatabase);
        
        $this->assertEquals($oNewEntity->oProcessingDate,$oProcessingDate);
        $this->assertEquals($oNewEntity->iAccountID,$iAccountId);
        $this->assertEquals($oNewEntity->fBalance,$fBalance);
        $this->assertEquals($oNewEntity->iOrgUnitID,$iOrgUnitId);
     
        
        # test entity to database mapper
        $aNewDatabase = $oBuilder->demolish($oEntity);
        
        $this->assertEquals($aNewDatabase['process_dt'], $oProcessingDate);
        $this->assertEquals($aNewDatabase['account_id'], $iAccountId);
        $this->assertEquals($aNewDatabase['balance'], $fBalance);
        $this->assertEquals($aNewDatabase['org_unit_id'], $iOrgUnitId);
        
    }
    
    
}
/* End of class */