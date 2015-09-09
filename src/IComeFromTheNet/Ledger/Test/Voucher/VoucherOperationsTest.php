<?php
namespace IComeFromTheNet\Ledger\Test\Voucher;

use DateTime;
use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use IComeFromTheNet\Ledger\Voucher\DB\VoucherGroup;
use IComeFromTheNet\Ledger\Voucher\DB\VoucherInstance;
use IComeFromTheNet\Ledger\Voucher\DB\VoucherGenRule;
use IComeFromTheNet\Ledger\Voucher\VoucherException;


class VoucherOperationsTest extends VoucherTestAbstract
{
    
    public function getDataSet()
    {
       return new ArrayDataSet([
           __DIR__.'/VoucherFixture.php',
        ]);
    }
    
    
    public function testVoucherGroupCreate()
    {
        
        $oContainer = $this->getContainer();
        
        $aOperations = $oContainer->getVoucherGroupOperations();
        
        $oCreateOperation = $aOperations['create'];
        
        # assert correct operation was returned
        $this->assertInstanceOf('\IComeFromTheNet\Ledger\Voucher\Operations\GroupCreate',$oCreateOperation);
        
        # test successful
        $oGroup = new VoucherGroup();
        $sName = 'Sales Vouchers';
        $bDisabled = true;
        $iSort = 100;
        $sSlugName = 'sales_vouchers';
        
        $oGroup->setDisabledStatus($bDisabled);
        $oGroup->setVoucherGroupName($sName);
        $oGroup->setSortOrder($iSort);
        $oGroup->setSlugName($sSlugName);
    
        
        $this->assertTrue($oCreateOperation->execute($oGroup));
        $this->assertNotEmpty($oGroup->getVoucherGroupId());
       
        
    }
    
    /**
     * @expectedException        IComeFromTheNet\Ledger\Voucher\VoucherException
     * @expectedExceptionMessage Unable to create new voucher group the Entity has a database id assigned already
     */
    public function testVoucherGroupFailesOnExisting()
    {
        $oContainer = $this->getContainer();
        $aOperations = $oContainer->getVoucherGroupOperations();
        $oCreateOperation = $aOperations['create'];
        
        # test if failes when given existing voucher
        $oGroup = new VoucherGroup();
        $iID    = 1;
        
        $oGroup->setVoucherGroupId($iID);
        $oCreateOperation->execute($oGroup);
    }
    
    
    public function testVoucherGroupRevise()
    {
        
        $oContainer = $this->getContainer();
        
        $aOperations = $oContainer->getVoucherGroupOperations();
        
        $oReviseOperation = $aOperations['update'];
        
        # assert correct operation was returned
        $this->assertInstanceOf('\IComeFromTheNet\Ledger\Voucher\Operations\GroupRevise',$oReviseOperation);
        
        $oGroup = new VoucherGroup();
        
        $sName = 'Sales Vouchers Next';
        $iID   = 1;
        $bDisabled = false;
        $iSort = 100;
        $oCreated = new DateTime();
        $sSlugName = 'sales_vouchers_next';
        
        $oGroup->setVoucherGroupId($iID);
        $oGroup->setDisabledStatus($bDisabled);
        $oGroup->setVoucherGroupName($sName);
        $oGroup->setSortOrder($iSort);
        $oGroup->setDateCreated($oCreated);
        $oGroup->setSlugName($sSlugName);
        
        $this->assertTrue($oReviseOperation->execute($oGroup));
        
    }
    
    public function testVoucherGroupRemove()
    {
        
        $oContainer = $this->getContainer();
        
        $aOperations = $oContainer->getVoucherGroupOperations();
        
        $oRemoveOperation = $aOperations['delete'];
        
        # assert correct operation was returned
        $this->assertInstanceOf('\IComeFromTheNet\Ledger\Voucher\Operations\GroupRemove',$oRemoveOperation);
        
        
        $oGroup = new VoucherGroup();
        $iID   = 1;
        
        $oGroup->setVoucherGroupId($iID);
        
        $oRemoveOperation->execute($oGroup);
    }
    
    
    public function testVoucherRuleCreate()
    {
        
        $oContainer = $this->getContainer();
        $aOperations = $oContainer->getVoucherRuleOperations();
        
        $oOperation = $aOperations['create'];
    
        # assert correct operation was returned
        $this->assertInstanceOf('\IComeFromTheNet\Ledger\Voucher\Operations\RuleCreate',$oOperation);
     
        
        $oRule = new VoucherGenRule();
        
        $oRule->setVoucherRuleName('Rule A');
        $oRule->setSlugRuleName('rule_a');
        $oRule->setVoucherPaddingCharacter('a');
        $oRule->setVoucherSuffix('_rule');
        $oRule->setVoucherPrefix('my_');
        $oRule->setVoucherLength(5);
        $oRule->setSequenceStrategyName('SEQUENCE');
        
        $oOperation->execute($oRule);
        
        $this->assertNotEmpty($oRule->getVoucherGenRuleId());
        
    }
    
    public function testVoucherRuleUpdate()
    {
        
        $oContainer = $this->getContainer();
        $aOperations = $oContainer->getVoucherRuleOperations();
        
        $oOperation = $aOperations['update'];
    
        # assert correct operation was returned
        $this->assertInstanceOf('\IComeFromTheNet\Ledger\Voucher\Operations\RuleRevise',$oOperation);
     
        
        $oRule = new VoucherGenRule();
        
        $oRule->setVoucherRuleName('Rule A');
        $oRule->setSlugRuleName('rule_a');
        $oRule->setVoucherPaddingCharacter('a');
        $oRule->setVoucherSuffix('_rule');
        $oRule->setVoucherPrefix('my_');
        $oRule->setVoucherLength(5);
        $oRule->setSequenceStrategyName('SEQUENCE');
        $oRule->setVoucherGenRuleId(1);
        
        $oOperation->execute($oRule);
        
        $this->assertNotEmpty($oRule->getVoucherGenRuleId());
        
    }
    
    public function testVoucherTypeCreate()
    {
        $oContainer = $this->getContainer();
        $aOperations = $oContainer->getVoucherTypeOperations();
        
        $oOperation = $aOperations['create'];
    
        # assert correct operation was returned
        $this->assertInstanceOf('\IComeFromTheNet\Ledger\Voucher\Operations\TypeCreate',$oOperation);
     
    }
    
    public function testVoucherTypeRevise()
    {
        $oContainer = $this->getContainer();
        $aOperations = $oContainer->getVoucherTypeOperations();
        
        $oOperation = $aOperations['update'];
    
        # assert correct operation was returned
        $this->assertInstanceOf('\IComeFromTheNet\Ledger\Voucher\Operations\TypeRevise',$oOperation);
     
    }
    
    public function testVoucherTypeExipre()
    {
        $oContainer = $this->getContainer();
        $aOperations = $oContainer->getVoucherTypeOperations();
        
        $oOperation = $aOperations['delete'];
    
        # assert correct operation was returned
        $this->assertInstanceOf('\IComeFromTheNet\Ledger\Voucher\Operations\TypeExpire',$oOperation);
     
    }
    
    /*
    
    public function testVoucherInstanceCreate()
    {
        $oContainer = $this->getContainer();
        $aOperations = $oContainer->getVoucherInstanceOperations();
        
        $oOperation = $aOperations['create'];
    
        # assert correct operation was returned
        $this->assertInstanceOf('\IComeFromTheNet\Ledger\Voucher\Operations\VoucherCreate',$oOperation);
        
        $oVoucher = new VoucherInstance();
        
        $oVoucher->setVoucherTypeId(1);
        $oVoucher->setVoucherCode('aaa_01');
         
        $oOperation->execute($oVoucher);
        
        $this->assertNotEmpty($oVoucher->getVoucherInstanceId());
    }
    */
    
    
}
/* End of class */