<?php
namespace IComeFromTheNet\GeneralLedger\Test;

use DateTime;
use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use DBALGateway\Feature\BufferedQueryLogger;

use IComeFromTheNet\GeneralLedger\Test\Base\TestWithContainer;
use IComeFromTheNet\GeneralLedger\TrialBalance\AccountTreeBuilder;


class AccountTreeTest extends TestWithContainer
{
   
   protected $aFixtures = ['example-system.php'];
   
   
   protected function getMockBalances()
   {
       return [
            ['account_id' => 28, 'balance' => 5 ]
           ,['account_id' => 46, 'balance' => 10]
           ,['account_id' => 47, 'balance' => 15]
           ,['account_id' => 6,  'balance' => 20]
           ,['account_id' => 8,  'balance' => 25]
           ,['account_id' => 9,  'balance' => 30]
           ,['account_id' => 40, 'balance' => 35]
           
        ];
       
   }
    
    
    public function testTreeProperties()
    {
        $oContainer = $this->getContainer();
        
        $oMockSource = $this->getMock('IComeFromTheNet\GeneralLedger\TrialBalance\DatasourceInterface');      
    
        
        $oAccountTree = new AccountTreeBuilder($oContainer->getDatabaseAdapter(),$oContainer->getAppLogger(),$oMockSource,$oContainer->getTableMap());
        
    
        $this->assertEquals($oContainer->getDatabaseAdapter(),$oAccountTree->getDatabaseAdapter());
        $this->assertEquals($oContainer->getAppLogger(),$oAccountTree->getAppLogger());
        $this->assertEquals($oMockSource,$oAccountTree->getEntrySource());
        
    }
    
    public function testTreeBuild()
    {
        $oContainer = $this->getContainer();
        
        $oMockSource = $this->getMock('IComeFromTheNet\GeneralLedger\TrialBalance\DatasourceInterface');      
    
        $oMockSource->expects($this->once())
                    ->method('getAccountBalances')
                    ->will($this->returnValue($this->getMockBalances())); 
    
        
        $oAccountTreeBuild = new AccountTreeBuilder($oContainer->getDatabaseAdapter(),$oContainer->getAppLogger(),$oMockSource,$oContainer->getTableMap());
        
        $oAccountTree = $oAccountTreeBuild->buildAccountTree();
        
        $this->assertNotEmpty($oAccountTree->getRootNodes());
        
    }  
    
}
/* End of class */