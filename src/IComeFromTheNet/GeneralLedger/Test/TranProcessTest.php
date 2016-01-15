<?php
namespace IComeFromTheNet\GeneralLedger\Test;

use DateTime;
use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use DBALGateway\Feature\BufferedQueryLogger;

use IComeFromTheNet\GeneralLedger\Test\Base\TestWithContainer;
use IComeFromTheNet\GeneralLedger\Entity\LedgerTransaction;
use IComeFromTheNet\GeneralLedger\Entity\LedgerEntry;

use IComeFromTheNet\GeneralLedger\TransactionProcessor;


class TranProcessTest extends TestWithContainer
{
   
   protected $aFixtures = ['example-system.php','tp-before.php'];
   
    
    
    protected function getTransactionExamples()
    {
        
        $oContainer = $this->getContainer();
        $oLogger    = $oContainer->getAppLogger();
        $oTransGateway   = $oContainer->getGatewayCollection()->getGateway('ledger_transaction');
        $oEntryGateway   = $oContainer->getGatewayCollection()->getGateway('ledger_entry');
        
        
        
        $oTransEntity = new LedgerTransaction($oTransGateway,$oLogger);
        
        $oTransEntity->iTransactionID  = null;
        $oTransEntity->iOrgUnitID      = 1;
        $oTransEntity->oProcessingDate = new DateTime('now');
        $oTransEntity->oOccuredDate    = new DateTime('now - 5 day');
        $oTransEntity->sVoucherNumber  = '10002';
        $oTransEntity->iAdjustmentID   = null;
        $oTransEntity->iUserID         = 1;
        $oTransEntity->iJournalTypeID  = 1;
        
        
        $oMovAEntity = new LedgerEntry($oEntryGateway,$oLogger);
        
        $oMovAEntity->iTransactionID = null;
        $oMovAEntity->iAccountID     = 46;
        $oMovAEntity->fMovement      = 100.00; 
        
        $oMovBEntity = new LedgerEntry($oEntryGateway,$oLogger);
        
        $oMovBEntity->iTransactionID = null;
        $oMovBEntity->iAccountID     = 47;
        $oMovBEntity->fMovement      = 20.00; 
        
        $oMovCEntity = new LedgerEntry($oEntryGateway,$oLogger);
        
        $oMovCEntity->iTransactionID = null;
        $oMovCEntity->iAccountID     = 47;
        $oMovCEntity->fMovement      = 105.00; 
         
        
        $oTransRevEntity = new LedgerTransaction($oTransGateway,$oLogger);
        
        $oTransRevEntity->iTransactionID  = null;
        $oTransRevEntity->iOrgUnitID      = 1;
        $oTransRevEntity->oProcessingDate = new DateTime('now');
        $oTransRevEntity->oOccuredDate    = new DateTime('now - 5 day');
        $oTransRevEntity->sVoucherNumber  = '10003';
        $oTransRevEntity->iAdjustmentID   = null;
        $oTransRevEntity->iUserID         = 1;
        $oTransRevEntity->iJournalTypeID  = 1;
        
        $oMovRevAEntity = new LedgerEntry($oEntryGateway,$oLogger);
        
        $oMovRevAEntity->iTransactionID = null;
        $oMovRevAEntity->iAccountID     = 46;
        $oMovRevAEntity->fMovement      = -100.00; 
        
        $oMovRevBEntity = new LedgerEntry($oEntryGateway,$oLogger);
        
        $oMovRevBEntity->iTransactionID = null;
        $oMovRevBEntity->iAccountID     = 47;
        $oMovRevBEntity->fMovement      = -20.00; 
        
        $oMovRevCEntity = new LedgerEntry($oEntryGateway,$oLogger);
        
        $oMovRevCEntity->iTransactionID = null;
        $oMovRevCEntity->iAccountID     = 47;
        $oMovRevCEntity->fMovement      = -105.00; 
        
         
        return array('tran' => $oTransEntity
                    ,'mov' => array($oMovAEntity,$oMovBEntity,$oMovCEntity)
                    
                    , 'adj_tran' => $oTransRevEntity
                    ,'adj_mov'   => array($oMovRevAEntity,$oMovRevBEntity,$oMovRevCEntity)
        );
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
        
        $this->successRunTest();
        
        $this->assertTablesEqual($oExpectedDataset->getTable('ledger_transaction'),$this->getConnection()->createDataSet()->getTable('ledger_transaction'));
        $this->assertTablesEqual($oExpectedDataset->getTable('ledger_entry'),$this->getConnection()->createDataSet()->getTable('ledger_entry'));
    }

  
    public function successRunTest()
    {
        $aTransactions = $this->getTransactionExamples();
        $oLogger   = $this->getContainer()->getAppLogger();
        $oDatabase = $this->getContainer()->getDatabaseAdapter();
       
       
        
        $oProcessor = new TransactionProcessor($oDatabase,$oLogger);
        $oProcessor->process($aTransactions['tran'],$aTransactions['mov']);
        
        # test with adjustment
        $oProcessor->process($aTransactions['adj_tran'],$aTransactions['adj_mov'],$aTransactions['tran']);
        
    }
    
    
    /**
     * @expectedException IComeFromTheNet\GeneralLedger\Exception\LedgerException
     * @expectedExceptionMessage Unable to process a new transaction a transaction must have at least one entry
     * 
     */ 
    public function testFailsWhenNoEntries()
    {
        $aTransactions = $this->getTransactionExamples();
        $oLogger   = $this->getContainer()->getAppLogger();
        $oDatabase = $this->getContainer()->getDatabaseAdapter();
       
        
        $oProcessor = new TransactionProcessor($oDatabase,$oLogger);
        $oProcessor->process($aTransactions['tran'],array());
        
        
    }
    
    /**
     * @expectedException IComeFromTheNet\GeneralLedger\Exception\LedgerException
     * @expectedExceptionMessageRegExp /Unable to save ledger transacrtion/  
     * 
     */
    public function testThrowsExceptionWhenTransactionFails()
    {
        $aTransactions = $this->getTransactionExamples();
        $oLogger   = $this->getContainer()->getAppLogger();
        $oDatabase = $this->getContainer()->getDatabaseAdapter();
      
        // cause a exception in validation
        $aTransactions['tran']->iTransactionID = 'aaaaa';
       
        
        $oProcessor = new TransactionProcessor($oDatabase,$oLogger);
        $oProcessor->process($aTransactions['tran'],$aTransactions['mov']);
        
        
    }
    
    
}
/* End of class */