<?php
namespace IComeFromTheNet\GeneralLedger\Test;

use DateTime;
use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use DBALGateway\Feature\BufferedQueryLogger;

use IComeFromTheNet\GeneralLedger\Test\Base\TestWithContainer;
use IComeFromTheNet\GeneralLedger\Step\AggAllStep;
use IComeFromTheNet\GeneralLedger\Entity\LedgerTransaction;
use IComeFromTheNet\GeneralLedger\Entity\LedgerEntry;
use IComeFromTheNet\GeneralLedger\Step\AggUserStep;
use IComeFromTheNet\GeneralLedger\Step\AggOrgUnitStep;

use IComeFromTheNet\GeneralLedger\TransactionStepsDecorator;


class AggStepTest extends TestWithContainer
{
   
   protected $aFixtures = ['example-system.php','agg-before.php'];
   
    
    
    protected function getTransactionExamples()
    {
        
        $oContainer = $this->getContainer();
        $oLogger    = $oContainer->getAppLogger();
        $oTransGateway   = $oContainer->getGatewayCollection()->getGateway('ledger_transaction');
        $oEntryGateway   = $oContainer->getGatewayCollection()->getGateway('ledger_entry');
        
        
        
        $oTransEntity = new LedgerTransaction($oTransGateway,$oLogger);
        
        $oTransEntity->iTransactionID  = 2;
        $oTransEntity->iOrgUnitID      = 1;
        $oTransEntity->oProcessingDate = new DateTime('now');
        $oTransEntity->oOccuredDate    = new DateTime('now - 5 day');
        $oTransEntity->sVoucherNumber  = '1002';
        $oTransEntity->iAdjustmentID   = 3;
        $oTransEntity->iUserID         = 1;
        $oTransEntity->iJournalTypeID  = 1;
        
        
        $oMovAEntity = new LedgerEntry($oEntryGateway,$oLogger);
        
        $oMovAEntity->iTransactionID = 1;
        $oMovAEntity->iAccountID     = 46;
        $oMovAEntity->fMovement      = 100.00; 
        
        $oMovBEntity = new LedgerEntry($oEntryGateway,$oLogger);
        
        $oMovBEntity->iTransactionID = 1;
        $oMovBEntity->iAccountID     = 47;
        $oMovBEntity->fMovement      = 20.00; 
        
        $oMovCEntity = new LedgerEntry($oEntryGateway,$oLogger);
        
        $oMovCEntity->iTransactionID = 1;
        $oMovCEntity->iAccountID     = 47;
        $oMovCEntity->fMovement      = 105.00; 
         
         
        return array('tran' => $oTransEntity,'mov' => array($oMovAEntity,$oMovBEntity,$oMovCEntity));
        
    }
    
    public function testStepTransationProcessorDecorator()
    {
        $oMock = $this->getMockBuilder('IComeFromTheNet\\GeneralLedger\\TransactionProcessInterface')->getMock();
        
        $oMock->expects($this->once())
              ->method('process')
              ->will($this->returnValue(true));
        
        $oMockStep = $this->getMockBuilder('IComeFromTheNet\\GeneralLedger\\TransactionProcessInterface')
                        ->getMock();
        
        $oMockStep->expects($this->once())
                       ->method('process')
                       ->will($this->returnValue(true));    
        
        $oStepDecorator = new TransactionStepsDecorator($oMock,array($oMockStep));
        
        
        $aTransaction = $this->getTransactionExamples();
    
        # assert that steps had the process called on them
        $oStepDecorator->process($aTransaction['tran'],$aTransaction['mov']);
        
    }
    
    public function testStepTransationProcessorDecoratorStopsAfterFailure()
    {
        $oMock = $this->getMockBuilder('IComeFromTheNet\\GeneralLedger\\TransactionProcessInterface')->getMock();
        
        $oMock->expects($this->once())
              ->method('process')
              ->will($this->returnValue(true));
        
        $oMockStep = $this->getMockBuilder('IComeFromTheNet\\GeneralLedger\\TransactionProcessInterface')
                        ->getMock();
        
        $oMockStep->expects($this->once())
                       ->method('process')
                       ->will($this->returnValue(false));  
                       
        $oMockStepB = $this->getMockBuilder('IComeFromTheNet\\GeneralLedger\\TransactionProcessInterface')
                        ->getMock();
        
        $oMockStepB->expects($this->exactly(0))->method('process');
                     
        $oStepDecorator = new TransactionStepsDecorator($oMock,array($oMockStep,$oMockStepB));
        
        
        $aTransaction = $this->getTransactionExamples();
    
        # assert that steps had the process called on them
        $oStepDecorator->process($aTransaction['tran'],$aTransaction['mov']);
        
    }
    
    public function testAggSteps()
    {
        $oContainer = $this->getContainer();
        
        # create the logger for debug
        $oLog = new BufferedQueryLogger();
        $oLog->setMaxBuffer(100);
        $this->oLog = $oLog;
        $oContainer->getDatabaseAdapter()->getConfiguration()->setSQLLogger($oLog);
    
        
        $oExpectedDataset = $this->getDataSet(['example-system.php','agg-after.php']);
        
        $this->stepAllTest();
        $this->assertTablesEqual($oExpectedDataset->getTable('ledger_daily'),$this->getConnection()->createDataSet()->getTable('ledger_daily'));
    
        $this->stepUserTest();
        $this->assertTablesEqual($oExpectedDataset->getTable('ledger_daily_user'),$this->getConnection()->createDataSet()->getTable('ledger_daily_user'));
        
        $this->stepOrgTest();
        $this->assertTablesEqual($oExpectedDataset->getTable('ledger_daily_org'),$this->getConnection()->createDataSet()->getTable('ledger_daily_org'));
        
    }
    
    
    public function stepAllTest() 
    {
        $aTableMap = $this->getContainer()->getTableMap();
        $oLogger   = $this->getContainer()->getAppLogger();
        $oDatabase = $this->getContainer()->getDatabaseAdapter();
        
        $oStep = new AggAllStep($oLogger,$oDatabase,$aTableMap);
        
        $aTransaction = $this->getTransactionExamples();
        
        $oStep->process($aTransaction['tran'],$aTransaction['mov']);
        
        
    }
    
    public function stepUserTest() 
    {
        $aTableMap = $this->getContainer()->getTableMap();
        $oLogger   = $this->getContainer()->getAppLogger();
        $oDatabase = $this->getContainer()->getDatabaseAdapter();
        
        $oStep = new AggUserStep($oLogger,$oDatabase,$aTableMap);
        
        $aTransaction = $this->getTransactionExamples();
        
        $oStep->process($aTransaction['tran'],$aTransaction['mov']);
        
        
    }
    
    public function stepOrgTest() 
    {
        $aTableMap = $this->getContainer()->getTableMap();
        $oLogger   = $this->getContainer()->getAppLogger();
        $oDatabase = $this->getContainer()->getDatabaseAdapter();
        
        $oStep = new AggOrgUnitStep($oLogger,$oDatabase,$aTableMap);
        
        $aTransaction = $this->getTransactionExamples();
        
        $oStep->process($aTransaction['tran'],$aTransaction['mov']);
        
        
    }
    
    
}
/* End of class */