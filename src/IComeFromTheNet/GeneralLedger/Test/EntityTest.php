<?php
namespace IComeFromTheNet\GeneralLedger\Test;

use DateTime;
use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use DBALGateway\Feature\BufferedQueryLogger;

use IComeFromTheNet\GeneralLedger\Test\Base\TestWithContainer;
use IComeFromTheNet\GeneralLedger\Entity\LedgerAccount;
use IComeFromTheNet\GeneralLedger\Entity\LedgerJournalType;
use IComeFromTheNet\GeneralLedger\Entity\LedgerOrganisationUnit;
use IComeFromTheNet\GeneralLedger\Entity\LedgerUser;
use IComeFromTheNet\GeneralLedger\Entity\LedgerTransaction;
use IComeFromTheNet\GeneralLedger\Entity\LedgerEntry;


class EntityAccountTest extends TestWithContainer
{
   
   protected $aFixtures = ['entity-before.php'];
   
    
    
    public function testEntityActiveRecordMethod()
    {
        $oContainer = $this->getContainer();
        
        # create the logger for debug
        $oLog = new BufferedQueryLogger();
        $oLog->setMaxBuffer(100);
        $this->oLog = $oLog;
        $oContainer->getDatabaseAdapter()->getConfiguration()->setSQLLogger($oLog);
    
        
        $oExpectedDataset = $this->getDataSet(['entity-after.php']);
        
       
        
        # test account entity
        $this->entityAccountTest();
        $this->assertTablesEqual($oExpectedDataset->getTable('ledger_account'),$this->getConnection()->createDataSet()->getTable('ledger_account'));
    
        $this->entityJournalTypeTest();
        $this->assertTablesEqual($oExpectedDataset->getTable('ledger_journal_type'),$this->getConnection()->createDataSet()->getTable('ledger_journal_type'));
    
        $this->testEntityOrganisationUnit();
        $this->assertTablesEqual($oExpectedDataset->getTable('ledger_org_unit'),$this->getConnection()->createDataSet()->getTable('ledger_org_unit'));
        
        $this->testEntityLedgerUser();
        $this->assertTablesEqual($oExpectedDataset->getTable('ledger_user'),$this->getConnection()->createDataSet()->getTable('ledger_user'));
    
        $this->testEntityLedgerTransaction();
        $this->assertTablesEqual($oExpectedDataset->getTable('ledger_transaction'),$this->getConnection()->createDataSet()->getTable('ledger_transaction'));
    
        $this->testEntityLedgerEntry();
        $this->assertTablesEqual($oExpectedDataset->getTable('ledger_entry'),$this->getConnection()->createDataSet()->getTable('ledger_entry'));
    
    }
    
    
    
    
    protected function entityAccountTest()
    {
        $oContainer = $this->getContainer();
        $oLogger    = $oContainer->getAppLogger();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('ledger_account');
        
        # Account Remove
        $oEntity = new LedgerAccount($oGateway,$oLogger);
        
        $oEntity->iAccountID = 3;
        $oEntity->sAccountNumber = '1-0002';
        $oEntity->sAccountName = 'Account to Remove';
        $oEntity->sAccountNameSlug = 'account_to_remove';
        $oEntity->bHideUI   = false;
        $oEntity->bIsLeft   = false;
        $oEntity->bIsRight  = true;
        
        $bResult = $oEntity->remove();
        
        $this->assertTrue($bResult);
        $this->assertNotEmpty($oEntity->iAccountID);
        
        # Account Create 
      
        $oEntity = new LedgerAccount($oGateway,$oLogger);
        
        $oEntity->sAccountNumber = '1-0004';
        $oEntity->sAccountName = 'Example Account 1';
        $oEntity->sAccountNameSlug = 'example_account_1';
        $oEntity->bHideUI   = false;
        $oEntity->bIsLeft   = true;
        $oEntity->bIsRight  = false;
        
        $bResult = $oEntity->save();
        
        $this->assertTrue($bResult);
        $this->assertNotEmpty($oEntity->iAccountID); 
        
        
        
        # Account Update
        $oEntity->iAccountID    = 2;
        $oEntity->sAccountNumber = '1-0001';
        $oEntity->sAccountName = 'Updated Account';
        $oEntity->sAccountNameSlug = 'updated_account';
        $oEntity->bHideUI   = true;
        $oEntity->bIsLeft   = true;
        $oEntity->bIsRight  = false;
        
        $bResult = $oEntity->save();
        
        $this->assertTrue($bResult);
               
        
    }
    
    public function entityJournalTypeTest()
    {
        $oContainer = $this->getContainer();
        $oLogger    = $oContainer->getAppLogger();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('ledger_journal_type');
        
        # Remove
        $oEntity = new LedgerJournalType($oGateway,$oLogger);
        
        $oEntity->iJournalTypeID  = 2;
        $oEntity->sJournalName   = 'To Be Removed';
        $oEntity->sJournalNameSlug = 'to_be_removed';
        $oEntity->bHideUI  = false;
        
        $bResult = $oEntity->remove();
        
        $this->assertTrue($bResult);
        
        
        # Create
        $oEntity = new LedgerJournalType($oGateway,$oLogger);
        
        $oEntity->sJournalName   = 'New Created';
        $oEntity->sJournalNameSlug = 'new_created';
        $oEntity->bHideUI  = false;
        
        $bResult = $oEntity->save();
        
        $this->assertTrue($bResult);
        $this->assertNotEmpty($oEntity->iJournalTypeID); 
        
        # Update
        $oEntity = new LedgerJournalType($oGateway,$oLogger);
        
        $oEntity->iJournalTypeID  = 3;
        $oEntity->sJournalName   = 'Updated Journal';
        $oEntity->sJournalNameSlug = 'updated_journal';
        $oEntity->bHideUI  = true;
        
        $bResult = $oEntity->save();
        
        $this->assertTrue($bResult);
        
        
        
    }
    
    
    public function testEntityOrganisationUnit()
    {
        $oContainer = $this->getContainer();
        $oLogger    = $oContainer->getAppLogger();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('ledger_org_unit');
        
        # Remove
        $oEntity = new LedgerOrganisationUnit($oGateway,$oLogger);
        
        $oEntity->iOrgUnitID        = 2;
        $oEntity->sOrgUnitName      = 'Unit Be Removed';
        $oEntity->sOrgunitNameSlug  = 'unit_be_removed';
        $oEntity->bHideUI           = false;
        
        $bResult = $oEntity->remove();
        
        $this->assertTrue($bResult);
        
        # Create
        
        $oEntity = new LedgerOrganisationUnit($oGateway,$oLogger);
        
        $oEntity->sOrgUnitName      = 'New Org Unit';
        $oEntity->sOrgunitNameSlug  = 'new_org_unit';
        $oEntity->bHideUI           = false;
        
        $bResult = $oEntity->save();
        
        $this->assertTrue($bResult);
        $this->assertNotEmpty($oEntity->iOrgUnitID); 
        
        # Update
        
        $oEntity = new LedgerOrganisationUnit($oGateway,$oLogger);
        
        $oEntity->iOrgUnitID        = 3;
        $oEntity->sOrgUnitName      = 'Updated Org Unit';
        $oEntity->sOrgunitNameSlug  = 'updated_org_unit';
        $oEntity->bHideUI           = true;
        
        $bResult = $oEntity->save();
        
        $this->assertTrue($bResult);
        
        
    }
    
    public function testEntityLedgerUser()
    {
        $oContainer = $this->getContainer();
        $oLogger    = $oContainer->getAppLogger();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('ledger_user');
        
        # Remove
        $oEntity = new LedgerUser($oGateway,$oLogger);
        
        $oEntity->iUserID        = 2;
        $oEntity->sExternalGUID  = '000439C2-3A34-DAB8-C7AB-852CA6EC98D8';
        $oEntity->oRegoDate      = new DateTime('now - 5 day');
        $oEntity->oRegoDate->setTime(0,0,0);
        
        
        $bResult = $oEntity->remove();
        
        $this->assertTrue($bResult);
        
        # Test Create
        $oEntity = new LedgerUser($oGateway,$oLogger);
        
        $oEntity->sExternalGUID  = '6E34457C-BF12-20A0-AEC8-B8FE436CE304';
        $oEntity->oRegoDate      = new DateTime('now - 9 day');
        $oEntity->oRegoDate->setTime(0,0,0);
        
        $bResult = $oEntity->save();
        $this->assertNotEmpty($oEntity->iUserID); 
       
        
    }
    
    public function testEntityLedgerTransaction()
    {
        $oContainer = $this->getContainer();
        $oLogger    = $oContainer->getAppLogger();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('ledger_transaction');
        
        # Create
        $oEntity = new LedgerTransaction($oGateway,$oLogger);
        
        $oEntity->iOrgUnitID      = 1;
        $oEntity->oProcessingDate = new DateTime('now');
        $oEntity->oOccuredDate    = new DateTime('now - 10 day');
        $oEntity->sVoucherNumber  = '10004';
        $oEntity->iAdjustmentID   = null;
        $oEntity->iUserID         = 1;
        $oEntity->iJournalTypeID  = 1;
        
        $bResult = $oEntity->save();
        $this->assertTrue($bResult);
        $this->assertNotEmpty($oEntity->iTransactionID); 
       
        
        
        # test update (Adjustment id is set)
        
        $oEntity = new LedgerTransaction($oGateway,$oLogger);
        
        $oEntity->iTransactionID  = 2;
        $oEntity->iOrgUnitID      = 1;
        $oEntity->oProcessingDate = new DateTime('now');
        $oEntity->oOccuredDate    = new DateTime('now - 5 day');
        $oEntity->sVoucherNumber  = '1002';
        $oEntity->iAdjustmentID   = 3;
        $oEntity->iUserID         = 1;
        $oEntity->iJournalTypeID  = 1;
        
        $oEntity->save();
        $this->assertTrue($bResult);
    }
    
    public function testEntityLedgerEntry()
    {
        $oContainer = $this->getContainer();
        $oLogger    = $oContainer->getAppLogger();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('ledger_entry');
        
        
        # create
        $oEntity = new LedgerEntry($oGateway,$oLogger);
        
        $oEntity->iTransactionID = 1;
        $oEntity->iAccountID     = 4;
        $oEntity->fMovement      = 100.00;
        
        $bResult = $oEntity->save();
        $this->assertTrue($bResult);
        $this->assertNotEmpty($oEntity->iEntryID); 
        
    }
    
}
/* End of class */