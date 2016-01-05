<?php
namespace IComeFromTheNet\GeneralLedger\Test;

use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use DBALGateway\Feature\BufferedQueryLogger;

use IComeFromTheNet\GeneralLedger\Test\Base\TestWithContainer;
use IComeFromTheNet\GeneralLedger\Entity\LedgerAccount;


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
        $this->EntityAccountTest();
        $this->assertTablesEqual($oExpectedDataset->getTable('ledger_account'),$this->getConnection()->createDataSet()->getTable('ledger_account'));
    
    
    
        
    }
    
    
    
    protected function EntityAccountTest()
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
        /*
        $oEntity = new LedgerAccount($oGateway,$oLogger);
        
        $oEntity->sAccountNumber = '1-00000';
        $oEntity->sAccountName = 'Example Account 1';
        $oEntity->sAccountNameSlug = 'example_account_1';
        $oEntity->bHideUI   = false;
        $oEntity->bIsLeft   = true;
        $oEntity->bIsRight  = false;
        
        $bResult = $oEntity->save();
        
        $this->assertTrue($bResult);
        $this->assertNotEmpty($oEntity->iAccountID); */
        
        
        
        # Account Update
               
        
    }
    
    
    
    
    
}
/* End of class */