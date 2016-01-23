<?php
namespace IComeFromTheNet\GeneralLedger\Test;

use DateTime;
use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use DBALGateway\Feature\BufferedQueryLogger;
use IComeFromTheNet\GeneralLedger\Test\Base\TestWithContainer;
use IComeFromTheNet\GeneralLedger\TransactionBuilder;


class TranBuilderTest extends TestWithContainer
{
   
   protected $aFixtures = ['example-system.php','tp-before.php'];
   
    
    
    protected function getTransactionExamples()
    {
        
        $oContainer = $this->getContainer();
        $oLogger    = $oContainer->getAppLogger();
        $oTransGateway   = $oContainer->getGatewayCollection()->getGateway('ledger_transaction');
        $oEntryGateway   = $oContainer->getGatewayCollection()->getGateway('ledger_entry');
        
        
        
    
    }
    
    
    public function testAggSteps()
    {
        $oContainer = $this->getContainer();
        
        # create the logger for debug
        $oLog = new BufferedQueryLogger();
        $oLog->setMaxBuffer(100);
        $this->oLog = $oLog;
        $oContainer->getDatabaseAdapter()->getConfiguration()->setSQLLogger($oLog);
    
        
        $oExpectedDataset = $this->getDataSet(['example-system.php','tp-after.php']);
        
        $oTran = $this->successRunTest();
        $this->successRunAdjustment($oTran);
        
        $this->successHumanLookups();
        
        $this->assertTablesEqual($oExpectedDataset->getTable('ledger_transaction'),$this->getConnection()->createDataSet()->getTable('ledger_transaction'));
        $this->assertTablesEqual($oExpectedDataset->getTable('ledger_entry'),$this->getConnection()->createDataSet()->getTable('ledger_entry'));
    }

  
    public function successRunTest()
    {
        $oProcessor = new TransactionBuilder($this->getContainer());
        
        # assert Build the Transaction object as expected
        
        $iOrgUnitID      = 1;
        $oProcessingDate = new DateTime('now');
        $oOccuredDate    = new DateTime('now - 5 day');
        $sVoucherNumber  = '10002';
        $iUserID         = 1;
        $iJournalTypeID  = 1;
        
        $oProcessor->setProcessingDate($oProcessingDate); 
        $oProcessor->setOccuredDate($oOccuredDate);
        $oProcessor->setOrgUnit($iOrgUnitID);
        $oProcessor->setVoucherNumber($sVoucherNumber);
        $oProcessor->setJournalType($iJournalTypeID);
        $oProcessor->setUser($iUserID);
        
        $oTran = $oProcessor->getTransactionHeader();
        
        $this->assertEquals($iOrgUnitID, $oTran->iOrgUnitID);
        $this->assertEquals($oProcessingDate, $oTran->oProcessingDate);
        $this->assertEquals($oOccuredDate, $oTran->oOccuredDate);
        $this->assertEquals($sVoucherNumber, $oTran->sVoucherNumber);
        $this->assertEquals($iUserID, $oTran->iUserID);
        $this->assertEquals($iJournalTypeID, $oTran->iJournalTypeID);
    
        
        # assert build ledger entries as expected
        
        $oProcessor->addAccountMovement('2-1120',100);
        $oProcessor->addAccountMovement('2-1130',20.00);
        $oProcessor->addAccountMovement('2-1130',105.00);

        $aEntries = $oProcessor->getLedgerEntries();
    
        $this->assertCount(3,$aEntries);
        
        // lookup of account number => account id worked
        $this->assertEquals(46, $aEntries[0]->iAccountID);
        $this->assertEquals(47, $aEntries[1]->iAccountID);
        $this->assertEquals(47, $aEntries[2]->iAccountID);
        
        $this->assertEquals(100,$aEntries[0]->fMovement);
        $this->assertEquals(20.00,$aEntries[1]->fMovement);
        $this->assertEquals(105.00,$aEntries[2]->fMovement);
        
        # execute the process
        $oProcessor->processTransaction();
        
        
        return $oTran;
    }
    
    public function successHumanLookups()
    {
        $oProcessor = new TransactionBuilder($this->getContainer());
        
        # assert Build the Transaction object as expected
        
        $iOrgUnitID      = 'homeoffice';
        $oProcessingDate = new DateTime('now');
        $oOccuredDate    = new DateTime('now - 6 day');
        $sVoucherNumber  = '10004';
        $iUserID         = '586DB7DF-57C3-F7D5-639D-0A9779AF79BD';
        $iJournalTypeID  = 'sales_journal';
        
        $oProcessor->setProcessingDate($oProcessingDate); 
        $oProcessor->setOccuredDate($oOccuredDate);
        $oProcessor->setOrgUnit($iOrgUnitID);
        $oProcessor->setVoucherNumber($sVoucherNumber);
        $oProcessor->setJournalType($iJournalTypeID);
        $oProcessor->setUser($iUserID);
        
        $oTran = $oProcessor->getTransactionHeader();
        
        $this->assertEquals(1, $oTran->iOrgUnitID);
        $this->assertEquals($oProcessingDate, $oTran->oProcessingDate);
        $this->assertEquals($oOccuredDate, $oTran->oOccuredDate);
        $this->assertEquals($sVoucherNumber, $oTran->sVoucherNumber);
        $this->assertEquals(1, $oTran->iUserID);
        $this->assertEquals(1, $oTran->iJournalTypeID);

    }
    
    public function successRunAdjustment($oTran)
    {
        $oProcessor = new TransactionBuilder($this->getContainer());
        
        # assert Build the Transaction object as expected
        
        $iOrgUnitID      = 1;
        $oProcessingDate = new DateTime('now');
        $oOccuredDate    = new DateTime('now - 5 day');
        $sVoucherNumber  = '10003';
        $iUserID         = 1;
        $iJournalTypeID  = 1;
        
        $oProcessor->setProcessingDate($oProcessingDate); 
        $oProcessor->setOccuredDate($oOccuredDate);
        $oProcessor->setOrgUnit($iOrgUnitID);
        $oProcessor->setVoucherNumber($sVoucherNumber);
        $oProcessor->setJournalType($iJournalTypeID);
        $oProcessor->setUser($iUserID);
    
    
        $oProcessor->processAdjustment($oTran);
        
    
    }
    
    /**
     * @expectedException IComeFromTheNet\GeneralLedger\Exception\LedgerException
     * @expectedExceptionMessage Unable to process transaction there are no ledger entries
     */ 
    public function testFailsWhenNoMovements()
    {
        $oProcessor = new TransactionBuilder($this->getContainer());
        
        # assert Build the Transaction object as expected
        
        $iOrgUnitID      = 1;
        $oProcessingDate = new DateTime('now');
        $oOccuredDate    = new DateTime('now - 5 day');
        $sVoucherNumber  = '10003';
        $iUserID         = 1;
        $iJournalTypeID  = 1;
        
        $oProcessor->setProcessingDate($oProcessingDate); 
        $oProcessor->setOccuredDate($oOccuredDate);
        $oProcessor->setOrgUnit($iOrgUnitID);
        $oProcessor->setVoucherNumber($sVoucherNumber);
        $oProcessor->setJournalType($iJournalTypeID);
        $oProcessor->setUser($iUserID);
    
    
        $oProcessor->processTransaction();
        
        
    }
    
    /**
     * @expectedException IComeFromTheNet\GeneralLedger\Exception\LedgerException
     * @expectedExceptionMessage    Not allowed to set ledger entries when process a reversal, system will do it for you
        
     */ 
    public function testFailsAgjWhenMovementsSet()
    {
        $oProcessor = new TransactionBuilder($this->getContainer());
        
        # assert Build the Transaction object as expected
        
        $iOrgUnitID      = 1;
        $oProcessingDate = new DateTime('now');
        $oOccuredDate    = new DateTime('now - 5 day');
        $sVoucherNumber  = '10003';
        $iUserID         = 1;
        $iJournalTypeID  = 1;
        
        $oProcessor->setProcessingDate($oProcessingDate); 
        $oProcessor->setOccuredDate($oOccuredDate);
        $oProcessor->setOrgUnit($iOrgUnitID);
        $oProcessor->setVoucherNumber($sVoucherNumber);
        $oProcessor->setJournalType($iJournalTypeID);
        $oProcessor->setUser($iUserID);
    
    
        $oProcessor->addAccountMovement('2-1120',100);
        $oProcessor->addAccountMovement('2-1130',20.00);
        $oProcessor->addAccountMovement('2-1130',105.00);

    
        $oProcessor->processAdjustment($oProcessor->getTransactionHeader());
        
        
    }
    
    /**
     * @expectedException IComeFromTheNet\GeneralLedger\Exception\LedgerException
     * @expectedExceptionMessage A transaction at 500 has no ledger entries, unable to process adjustment
     */ 
    public function testBadTransactionStopsAdj()
    {
        $oProcessor = new TransactionBuilder($this->getContainer());
        
        # assert Build the Transaction object as expected
        
        $iOrgUnitID      = 1;
        $oProcessingDate = new DateTime('now');
        $oOccuredDate    = new DateTime('now - 5 day');
        $sVoucherNumber  = '10003';
        $iUserID         = 1;
        $iJournalTypeID  = 1;
        
        $oProcessor->setProcessingDate($oProcessingDate); 
        $oProcessor->setOccuredDate($oOccuredDate);
        $oProcessor->setOrgUnit($iOrgUnitID);
        $oProcessor->setVoucherNumber($sVoucherNumber);
        $oProcessor->setJournalType($iJournalTypeID);
        $oProcessor->setUser($iUserID);
    
 
        $oTran = $oProcessor->getTransactionHeader();
    
        $oTran->iTransactionID = 500;
    
        $oProcessor->processAdjustment($oTran);
        
        
    }
}
/* End of class */