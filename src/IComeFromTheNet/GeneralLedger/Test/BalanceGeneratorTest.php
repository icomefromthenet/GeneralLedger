<?php
namespace IComeFromTheNet\GeneralLedger\Test;

use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use IComeFromTheNet\GeneralLedger\Test\Base\TestWithContainer;
use IComeFromTheNet\GeneralLedger\TrialBalance\AccountTree;
use IComeFromTheNet\GeneralLedger\TrialBalance\BalanceGenerator;


class BalanceGeneratorTest extends TestWithContainer
{
   
    protected $aFixtures = ['example-system.php'];
  
  
   protected function getDemoAccountTree()
   {
       $oAccountTree = new AccountTree([
         ['id' => 2, 'parent' => 1, 'account_number' => '1001', 'balance' => 5.00, 'account_name' => 'Demo A', 'account_name_slug' => 'demo_a', 'hide_ui' => false, 'is_debit' => true, 'is_credit' => false]
        ,['id' => 3, 'parent' => 1, 'account_number' => '1002', 'balance' => -5.00, 'account_name' => 'Demo B', 'account_name_slug' => 'demo_b', 'hide_ui' => false, 'is_debit' => false, 'is_credit' => true]

           
        ],['rootid'=>1]);
       
        
        $oAccountTree->calculateCombinedBalances();
        
        return $oAccountTree;
       
   }
    
   public function testTrialBalanceGenerator()
   {
       $oBalanceGen = new BalanceGenerator($this->getDemoAccountTree());
       
       $aAccountList =  $oBalanceGen->buildTrialBalance();
       
       
       # we should have some LedgerBlances in this account list
       $this->assertCount(3,$aAccountList);
        
        
       # test if subtotals are expected     
       $oSubTotal = end($aAccountList);
       $this->assertEquals(5,$oSubTotal->fDebit);
       $this->assertEquals(-5,$oSubTotal->fCredit);
       
       
   }
   
   
}
/* End of class */