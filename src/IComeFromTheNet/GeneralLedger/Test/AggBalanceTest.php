<?php
namespace IComeFromTheNet\GeneralLedger\Test;

use DateTime;
use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use IComeFromTheNet\GeneralLedger\Test\Base\TestWithContainer;
use IComeFromTheNet\GeneralLedger\TrialBalance\AggAllSource;
use IComeFromTheNet\GeneralLedger\TrialBalance\AggUserSource;
use IComeFromTheNet\GeneralLedger\TrialBalance\AggOrgSource;


class AggBalanceTest extends TestWithContainer
{
   
    
    protected $aFixtures = ['example-system.php','aggbal-before.php'];
    
    
    public function testAllSource()
    {
        $oTrialDate = new DateTime('now');    
        $oDatabase  = $this->getContainer()->getDatabaseAdapter();
        $aTableMap  = $this->getContainer()->getTableMap();
        
        $oSource = new AggAllSource($oTrialDate,$oDatabase,$aTableMap);
        
        # Test Properties
        $this->assertEquals($oTrialDate,$oSource->getTrialDate());
        $this->assertEquals($oDatabase,$oSource->getDatabaseAdapter());
        $this->assertEquals($aTableMap,$oSource->getTableMap());
        
        # test execute
        $aBalances = $oSource->getAccountBalances();
        
        $this->assertEquals($aBalances[46]['balance'],134.04);
        $this->assertEquals($aBalances[46]['account_id'],46);
        
        $this->assertEquals($aBalances[47]['balance'],106.78);
        $this->assertEquals($aBalances[47]['account_id'],47);
    }
   
   
    public function testUserSource()
    {
        $oTrialDate = new DateTime('now');    
        $oDatabase  = $this->getContainer()->getDatabaseAdapter();
        $aTableMap  = $this->getContainer()->getTableMap();
        
        $oSource = new AggUserSource($oTrialDate,$oDatabase,$aTableMap,1);
        
        # Test Properties
        $this->assertEquals($oTrialDate,$oSource->getTrialDate());
        $this->assertEquals($oDatabase,$oSource->getDatabaseAdapter());
        $this->assertEquals($aTableMap,$oSource->getTableMap());
        $this->assertEquals(1,$oSource->getUser());
        
        # test execute
        $aBalances = $oSource->getAccountBalances();
        
        $this->assertEquals($aBalances[46]['balance'],134.04);
        $this->assertEquals($aBalances[46]['account_id'],46);
        
        $this->assertEquals($aBalances[47]['balance'],106.78);
        $this->assertEquals($aBalances[47]['account_id'],47);
        
    }
    
    public function testOrgSource()
    {
        $oTrialDate = new DateTime('now');    
        $oDatabase  = $this->getContainer()->getDatabaseAdapter();
        $aTableMap  = $this->getContainer()->getTableMap();
        
        $oSource = new AggOrgSource($oTrialDate,$oDatabase,$aTableMap,1);
        
        # Test Properties
        $this->assertEquals($oTrialDate,$oSource->getTrialDate());
        $this->assertEquals($oDatabase,$oSource->getDatabaseAdapter());
        $this->assertEquals($aTableMap,$oSource->getTableMap());
        $this->assertEquals(1,$oSource->getOrg());
        
        # test execute
        $aBalances = $oSource->getAccountBalances();
        
        $this->assertEquals($aBalances[46]['balance'],134.04);
        $this->assertEquals($aBalances[46]['account_id'],46);
        
        $this->assertEquals($aBalances[47]['balance'],106.78);
        $this->assertEquals($aBalances[47]['account_id'],47);
        
    }
    
}
/* End of class */