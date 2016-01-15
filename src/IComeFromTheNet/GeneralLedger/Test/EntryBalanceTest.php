<?php
namespace IComeFromTheNet\GeneralLedger\Test;

use DateTime;
use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use IComeFromTheNet\GeneralLedger\Test\Base\TestWithContainer;
use IComeFromTheNet\GeneralLedger\TrialBalance\EntrySource;
use IComeFromTheNet\GeneralLedger\TrialBalance\EntryUserSource;
use IComeFromTheNet\GeneralLedger\TrialBalance\EntryOrgSource;


class EntryBalanceTest extends TestWithContainer
{
   
    
    protected $aFixtures = ['example-system.php','entry-before.php'];
    
    
    public function testAllSource()
    {
        $oTrialDate = new DateTime('now');    
        $oDatabase  = $this->getContainer()->getDatabaseAdapter();
        $aTableMap  = $this->getContainer()->getTableMap();
        
        $oSource = new EntrySource($oTrialDate,$oDatabase,$aTableMap);
        
        # Test Properties
        $this->assertEquals($oTrialDate,$oSource->getTrialDate());
        $this->assertEquals($oDatabase,$oSource->getDatabaseAdapter());
        $this->assertEquals($aTableMap,$oSource->getTableMap());
        
        # test execute
        $aBalances = $oSource->getAccountBalances();
        
        
        $this->assertEquals($aBalances[4]['balance'],300.00);
        $this->assertEquals($aBalances[4]['account_id'],4);
        
        $this->assertEquals($aBalances[5]['balance'],200.00);
        $this->assertEquals($aBalances[5]['account_id'],5);
        
        $this->assertEquals($aBalances[6]['balance'],40.00);
        $this->assertEquals($aBalances[6]['account_id'],6);
       
    }
   
   
    public function testUserSource()
    {
        $oTrialDate = new DateTime('now');    
        $oDatabase  = $this->getContainer()->getDatabaseAdapter();
        $aTableMap  = $this->getContainer()->getTableMap();
        
    
        $oSource = new EntryUserSource($oTrialDate,$oDatabase,$aTableMap,1);
        
        # Test Properties
        $this->assertEquals($oTrialDate,$oSource->getTrialDate());
        $this->assertEquals($oDatabase,$oSource->getDatabaseAdapter());
        $this->assertEquals($aTableMap,$oSource->getTableMap());
        $this->assertEquals(1,$oSource->getUser());
        
        # test execute
        $aBalances = $oSource->getAccountBalances();
        
        $this->assertEquals($aBalances[4]['balance'],300.00);
        $this->assertEquals($aBalances[4]['account_id'],4);
        
        $this->assertEquals($aBalances[5]['balance'],200.00);
        $this->assertEquals($aBalances[5]['account_id'],5);
        
        $this->assertEquals($aBalances[6]['balance'],40.00);
        $this->assertEquals($aBalances[6]['account_id'],6);
        
    }
    
    public function testOrgSource()
    {
        $oTrialDate = new DateTime('now');    
        $oDatabase  = $this->getContainer()->getDatabaseAdapter();
        $aTableMap  = $this->getContainer()->getTableMap();
        
        $oSource = new EntryOrgSource($oTrialDate,$oDatabase,$aTableMap,1);
        
        # Test Properties
        $this->assertEquals($oTrialDate,$oSource->getTrialDate());
        $this->assertEquals($oDatabase,$oSource->getDatabaseAdapter());
        $this->assertEquals($aTableMap,$oSource->getTableMap());
        $this->assertEquals(1,$oSource->getOrg());
    
        $aBalances = $oSource->getAccountBalances();
        
        $this->assertEquals($aBalances[4]['balance'],300.00);
        $this->assertEquals($aBalances[4]['account_id'],4);
        
        $this->assertEquals($aBalances[5]['balance'],200.00);
        $this->assertEquals($aBalances[5]['account_id'],5);
        
        $this->assertEquals($aBalances[6]['balance'],40.00);
        $this->assertEquals($aBalances[6]['account_id'],6);
    
    }
    
}
/* End of class */