<?php
namespace IComeFromTheNet\GeneralLedger\Test;

use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use IComeFromTheNet\GeneralLedger\Test\Base\TestWithContainer;
use IComeFromTheNet\GeneralLedger\TrialBalance\AccountNode;

class AccountNodeTest extends TestWithContainer
{
   
    public function getDataSet()
    {
       return new ArrayDataSet([
           __DIR__.'/fixture/example-system.php',
        ]);
    }
    
    protected function getMockAccountNode()
    {
        $iAccountId = 2;
        $iParentId  = 1;
        $sAccountNumber = '1-00001';
        $sAccountName = 'example account';
        $sAccountNameSlug = 'example_account';
        $bHideUI    = false;
        $bIsDebit = true;
        $bIsCredit = false;
        
        
        
        $oANode = new AccountNode($iAccountId
                                ,$iParentId
                                ,$sAccountNumber
                                ,$sAccountName
                                ,$sAccountNameSlug
                                ,$bHideUI
                                ,$bIsDebit
                                ,$bIsCredit);
        
        
        
        return $oANode;
    }
    
    public function testProperties()
    {
        
        $iAccountId = 2;
        $iParentId  = 1;
        $sAccountNumber = '1-00001';
        $sAccountName = 'example account';
        $sAccountNameSlug = 'example_account';
        $bHideUI    = false;
        $bIsDebit = true;
        $bIsCredit = false;
        
        
        
        $oANode = new AccountNode($iAccountId
                                ,$iParentId
                                ,$sAccountNumber
                                ,$sAccountName
                                ,$sAccountNameSlug
                                ,$bHideUI
                                ,$bIsDebit
                                ,$bIsCredit);
        
        
        # test properties
        
        $this->assertEquals($iAccountId,$oANode->getDatabaseID());
        $this->assertEquals($sAccountNumber,$oANode->getAccountNumber());
        $this->assertEquals($sAccountName,$oANode->getAccountName());
        $this->assertEquals($sAccountNameSlug,$oANode->getAccountNameSlug());
        $this->assertEquals($bIsDebit,$oANode->isDebit());
        $this->assertEquals($bIsCredit,$oANode->isCredit());
        
        
  
    }
    
    public function testFreezeFunctions()
    {
        $oANode = $this->getMockAccountNode();
          
        $this->assertFalse($oANode->isFrozen());
        $oANode->freeze();
        $oANode->isFrozen();
        
    }
    
    /**
     * @expectedException IComeFromTheNet\GeneralLedger\Exception\LedgerException
     */ 
    public function testCantGetBalanceUntilFrozen()
    {
        $oANode = $this->getMockAccountNode();
        
        $oANode->getBalance();
        
    }
    
    /**
     * @expectedException IComeFromTheNet\GeneralLedger\Exception\LedgerException
     */
    public function testCantUpdateBalanceWhenFrozen()
    {
        $oANode = $this->getMockAccountNode();
        
        $oANode->freeze();
        $oANode->setBasicBalance(100);
    
    }
    
    /**
     * @expectedException IComeFromTheNet\GeneralLedger\Exception\LedgerException
     */
    public function testCantCalculateBalanceWhenFrozen()
    {
        $oANode = $this->getMockAccountNode();
        
        $oANode->setBasicBalance(100);
        $oANode->freeze();
        $oANode->calculateCombinedBalances();
    
    }
    
    public function testBalanceProperties()
    {
        $oANode = $this->getMockAccountNode();
        
        $oANode->setBasicBalance(100);
        $oANode->freeze();
        $this->assertEquals(100,$oANode->getBalance());
        
    }
    
    public function testBalanceCal()
    {
        $oANode = $this->getMockAccountNode();
        
        $oANode->setBasicBalance(100);
        
        $aChild = new AccountNode(3, 2, '1-1006', 'child ac', 'child_ac', false, true, true);
        $oANode->addChild($aChild);
        $aChild->setBasicBalance(200);
        
        $oANode->calculateCombinedBalances();
        
        
        $this->assertEquals(300,$oANode->getBalance());
        
    }
}
/* End of class */