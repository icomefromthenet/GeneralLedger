<?php
namespace IComeFromTheNet\GeneralLedger\Test;

use DateTime;
use IComeFromTheNet\GeneralLedger\Test\Base\ArrayDataSet;
use DBALGateway\Feature\BufferedQueryLogger;
use IComeFromTheNet\GeneralLedger\Test\Base\TestWithContainer;
use IComeFromTheNet\GeneralLedger\TrialBalance;
use IComeFromTheNet\GeneralLedger\TrialBalanceOrgUnit;
use IComeFromTheNet\GeneralLedger\TrialBalanceUser;


class TrialBalanceTest extends TestWithContainer
{
   
   protected $aFixtures = ['example-system.php'];
   
    
    
   public function testAllBalance()
   {
       $oContainer = $this->getContainer();
       $oTrialDate = new DateTime('now');
       $bUseAgg    = false;
      
       $oBalance = new TrialBalance($oContainer,$oTrialDate,$bUseAgg);
       $this->assertEquals($oContainer,$oBalance->getContainer());
       $this->assertEquals($oTrialDate,$oBalance->getTrialDate());
       $this->assertEquals($bUseAgg,$oBalance->getUseAggSource());
       
       $this->assertNotEmpty($oBalance->getTrialBalance());
   }
    
    
   public function testAllBalanceWithAgg()
   {
       $oContainer = $this->getContainer();
       $oTrialDate = new DateTime('now');
       $bUseAgg    = true;
      
       $oBalance = new TrialBalance($oContainer,$oTrialDate,$bUseAgg);
       
       $oBalance->getTrialBalance();
       
       $this->assertNotEmpty($oBalance->getTrialBalance());
       
   }
   
   public function testOrgUnitBalance()
   {
       $oContainer = $this->getContainer();
       $oTrialDate = new DateTime('now');
       $bUseAgg    = false;
       $iOrgUnit   = 1;
      
       $oBalance = new TrialBalanceOrgUnit($oContainer,$oTrialDate,$iOrgUnit,$bUseAgg);
       $this->assertEquals($iOrgUnit,$oBalance->getOrgUnit());
       
       $oBalance->getTrialBalance();
       
       $this->assertNotEmpty($oBalance->getTrialBalance());
   }
   
   public function testOrgUnitBalanceWithAgg()
   {
       $oContainer = $this->getContainer();
       $oTrialDate = new DateTime('now');
       $bUseAgg    = true;
       $iOrgUnit   = 1;
      
       $oBalance = new TrialBalanceOrgUnit($oContainer,$oTrialDate,$iOrgUnit,$bUseAgg);
       
       $oBalance->getTrialBalance();
       
       $this->assertNotEmpty($oBalance->getTrialBalance());
       
   }
   
   public function testUserBalance()
   {
       $oContainer = $this->getContainer();
       $oTrialDate = new DateTime('now');
       $bUseAgg    = false;
       $iUser      = 1;
      
       $oBalance = new TrialBalanceUser($oContainer,$oTrialDate,$iUser,$bUseAgg);
       $this->assertEquals($iUser,$oBalance->getUser());
       
       $oBalance->getTrialBalance();
       
       $this->assertNotEmpty($oBalance->getTrialBalance());
   }
   
   public function testUserBalanceWithAgg()
   {
       $oContainer = $this->getContainer();
       $oTrialDate = new DateTime('now');
       $bUseAgg    = true;
       $iUser   = 1;
      
       $oBalance = new TrialBalanceUser($oContainer,$oTrialDate,$iUser,$bUseAgg);
       
       $oBalance->getTrialBalance();
       
       
       $this->assertNotEmpty($oBalance->getTrialBalance());
   }
   
}
/* End of class */