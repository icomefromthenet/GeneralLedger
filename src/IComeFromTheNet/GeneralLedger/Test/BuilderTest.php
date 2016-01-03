<?php
namespace IComeFromTheNet\GeneralLedger\Test;

use DateTime;
use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use IComeFromTheNet\GeneralLedger\Test\Base\TestWithContainer;
use IComeFromTheNet\GeneralLedger\Entity\CommonBuilder;
use IComeFromTheNet\GeneralLedger\Entity\Account;
use IComeFromTheNet\GeneralLedger\Entity\LedgerTransaction;
use IComeFromTheNet\GeneralLedger\Entity\LedgerEntry;


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
            'account_id' => $iAccountId
            ,'account_number' => $sAccountNumber
            ,'account_name' => $sAccountName
            ,'account_name_slug' => $sAccountNameSlug
            ,'hide_ui' => $bHideUi
            ,'is_left' => $bIsLeft
            ,'is_right' => $bIsRight
        );
        
        $oEntity = new Account($oGateway,$oLogger);
        
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
            'transaction_id'    => $iTransactionId
            ,'org_unit_id'      => $iOrgUnitId
            ,'process_dt'       => $oProcessingDate
            ,'occured_dt'       => $oOccuredDate
            ,'vouchernum'       => $sVoucherNum
            ,'journal_type_id'  => $iJournalTypeId
            ,'adjustment_id'    => $iAdjustmentId
            ,'user_id'          => $iUserId
            
        );
        
        $oEntity = new LedgerTransaction($oGateway,$oLogger);
        
        $oEntity->iTransactionID   = $iTransactionId;
        $oEntity->iOrgUnitID       = $iOrgUnitId;
        $oEntity->oProcessingDate  = $oProcessingDate;
        $oEntity->oOccuredDate     = $oOccuredDate;
        $oEntity->sVoucherNumber   = $sVoucherNum;
        $oEntity->iJournalTypeID   = $iJournalTypeId;
        $oEntity->iAdjustmentID    = $iAdjustmentId;
        $oEntity->iUserId          = $iUserId;


        # test database to Entity Mapper        
        $oNewEntity = $oBuilder->build($aDatabase);
        
        $this->assertEquals($oNewEntity->iTransactionID,$iTransactionId);
        $this->assertEquals($oNewEntity->iOrgUnitID,$iOrgUnitId);
        $this->assertEquals($oNewEntity->oProcessingDate,$oProcessingDate);
        $this->assertEquals($oNewEntity->oOccuredDate,$oOccuredDate);
        $this->assertEquals($oNewEntity->sVoucherNumber,$sVoucherNum);
        $this->assertEquals($oNewEntity->iJournalTypeID,$iJournalTypeId);
        $this->assertEquals($oNewEntity->iAdjustmentID,$iAdjustmentId);
        $this->assertEquals($oNewEntity->iUserId,$iUserId);

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
             'entry_id'       => $iEntryId
            ,'transaction_id' => $iTransactionId
            ,'account_id' => $iAccountId
            ,'movement'   => $fMovement
            
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
    
    
    
    
}
/* End of class */