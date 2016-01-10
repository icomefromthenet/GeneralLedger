<?php
namespace IComeFromTheNet\GeneralLedger\Test;

use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use DBALGateway\Feature\BufferedQueryLogger;

use IComeFromTheNet\GeneralLedger\Test\Base\TestWithContainer;
use IComeFromTheNet\GeneralLedger\Entity\LedgerAccount;
use IComeFromTheNet\GeneralLedger\Entity\LedgerJournalType;


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
        $oContainer->getDatabaseAdaper()->getConfiguration()->setSQLLogger($oLog);
    
        
        $oExpectedDataset = $this->getDataSet(['entity-after.php']);
        
       
        
        # test account entity
        $this->entityAccountTest();
        $this->assertTablesEqual($oExpectedDataset->getTable('ledger_account'),$this->getConnection()->createDataSet()->getTable('ledger_account'));
    
        $this->entityJournalTypeTest();
        $this->assertTablesEqual($oExpectedDataset->getTable('ledger_journal_type'),$this->getConnection()->createDataSet()->getTable('ledger_journal_type'));
    
        
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
        
        
    }
    
    
}
/* End of class */