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
        //$aBalances = $oSource->getAccountBalances();
    
       
    }
   
   
    public function testUserSource()
    {
        $oTrialDate = new DateTime('now');    
        $oDatabase  = $this->getContainer()->getDatabaseAdapter();
        $aTableMap  = $this->getContainer()->getTableMap();
        
       
        
    }
    
    public function testOrgSource()
    {
        $oTrialDate = new DateTime('now');    
        $oDatabase  = $this->getContainer()->getDatabaseAdapter();
        $aTableMap  = $this->getContainer()->getTableMap();
        
        
    }
    
}
/* End of class */