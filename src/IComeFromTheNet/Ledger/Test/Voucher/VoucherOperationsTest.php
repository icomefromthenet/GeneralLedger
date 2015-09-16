<?php
namespace IComeFromTheNet\Ledger\Test\Voucher;

use DateTime;
use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use IComeFromTheNet\Ledger\Voucher\DB\VoucherGroup;
use IComeFromTheNet\Ledger\Voucher\DB\VoucherInstance;
use IComeFromTheNet\Ledger\Voucher\DB\VoucherGenRule;
use IComeFromTheNet\Ledger\Voucher\DB\VoucherType;
use IComeFromTheNet\Ledger\Voucher\VoucherException;


class VoucherOperationsTest extends VoucherTestAbstract
{
    
    public function getDataSet()
    {
       return new ArrayDataSet([
           __DIR__.'/VoucherFixture.php',
        ]);
    }
    
    /**
     * @expectedException        IComeFromTheNet\Ledger\Voucher\VoucherException
     * @expectedExceptionMessage Unable to create new voucher group the Entity has a database id assigned already
     */
    public function testVoucherGroup()
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
        
        // Test if update a group
        
        $oReviseOperation = $aOperations['update'];
        
        # assert correct operation was returned
        $this->assertInstanceOf('\IComeFromTheNet\Ledger\Voucher\Operations\GroupRevise',$oReviseOperation);
     
        
        $sName = 'Sales Vouchers Next';
        $bDisabled = false;
        $iSort = 100;
        $sSlugName = 'sales_vouchers_next';
       
        $oGroup->setDisabledStatus($bDisabled);
        $oGroup->setVoucherGroupName($sName);
        $oGroup->setSlugName($sSlugName);
        $oGroup->setSortOrder($iSort);
        
        
        $bSuccess = $oReviseOperation->execute($oGroup);
        
        
        $this->assertTrue($bSuccess);
        
        
        // Test if remove a group
        
        $oRemoveOperation = $aOperations['delete'];
        
        # assert correct operation was returned
        $this->assertInstanceOf('\IComeFromTheNet\Ledger\Voucher\Operations\GroupRemove',$oRemoveOperation);
        
        $oRemoveOperation->execute($oGroup);
        
        
        // Test that cant create existing entity
        $oCreateOperation = $aOperations['create'];
        
        # test if failes when given existing voucher
        $oCreateOperation->execute($oGroup);
    }
    
    
   
     /**
     * @expectedException        IComeFromTheNet\Ledger\Voucher\VoucherException
     * @expectedExceptionMessage Unable to create new voucher rule the Entity has a database id assigned already
     */
    public function testVoucherRule()
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
        
        // test rule Update
        
        $oOperation = $aOperations['update'];
    
        # assert correct operation was returned
        $this->assertInstanceOf('\IComeFromTheNet\Ledger\Voucher\Operations\RuleRevise',$oOperation);
        
        $oRule->setVoucherRuleName('Rule A');
        $oRule->setSlugRuleName('rule_a');
        $oRule->setVoucherPaddingCharacter('a');
        $oRule->setVoucherSuffix('_rule');
        $oRule->setVoucherPrefix('my_');
        $oRule->setVoucherLength(5);
        $oRule->setSequenceStrategyName('SEQUENCE');
     
        
        $oOperation->execute($oRule);
        
        $this->assertNotEmpty($oRule->getVoucherGenRuleId());
        
        // test can create exsting entity
        
        $oOperation = $aOperations['create'];
         
        $oOperation->execute($oRule);
        
    }
    
   
    
    public function testVoucherType()
    {
        $oContainer = $this->getContainer();
        $aOperations = $oContainer->getVoucherTypeOperations();
        
        $oOperation = $aOperations['create'];
    
        # assert correct operation was returned
        $this->assertInstanceOf('\IComeFromTheNet\Ledger\Voucher\Operations\TypeCreate',$oOperation);
        
        $oType = new VoucherType();  
        
         $iVoucherTypeId = 1;
        $sName          ='test voucher';
        $sSlugName      ='test_voucher';
        $sDescription   = 'A sucessful test voucher';
        $oEnableFrom    = new DateTime();
        $oEnableTo      = new DateTime('NOW + 5 days');
        $iVoucherGroupId = 1;
        $iVoucherGenRuleId =1;
        
        
        $oType->setSlug($sSlugName);
        $oType->setName($sName);
        $oType->setDescription($sDescription);
        $oType->setEnabledFrom($oEnableFrom);
        $oType->setVoucherGroupId($iVoucherGroupId);
        $oType->setVoucherGenruleId($iVoucherGenRuleId);
        
        $oOperation->execute($oType);
        
        $this->assertNotEmpty($oType->getVoucherTypeId());
     
     
        // test update
     
        $aOperations = $oContainer->getVoucherTypeOperations();
        
        $oOperation = $aOperations['update'];
    
        # assert correct operation was returned
        $this->assertInstanceOf('\IComeFromTheNet\Ledger\Voucher\Operations\TypeRevise',$oOperation);
     
        $oType->setDescription('an updated description');
        
        $this->assertTrue($oOperation->execute($oType));
     
       // test delete no last date given
      
        $oOperation = $aOperations['delete'];
        $oType->setEnabledTo(null);
        $this->assertInstanceOf('\IComeFromTheNet\Ledger\Voucher\Operations\TypeExpire',$oOperation);
     
        $bResult = $oOperation->execute($oType);
        //var_dump($oContainer['TestQueryLog']->lastQuery());
        
        $this->assertTrue($bResult);
        $this->assertEquals($oContainer->getNow(),$oType->getEnabledTo());
        
        // Test delete if last date give
        $oOperation = $aOperations['delete'];
        $oType->setEnabledTo($oEnableTo);
        $this->assertInstanceOf('\IComeFromTheNet\Ledger\Voucher\Operations\TypeExpire',$oOperation);
     
        $bResult = $oOperation->execute($oType);
        $this->assertTrue($bResult);
        $this->assertEquals($oEnableTo,$oType->getEnabledTo());

    }
    
    
    public function testVoucherInstanceCreate()
    {
        $oContainer = $this->getContainer();
        $aOperations = $oContainer->getVoucherInstanceOperations();
        
        $oOperation = $aOperations['create'];
    
        # assert correct operation was returned
        $this->assertInstanceOf('\IComeFromTheNet\Ledger\Voucher\Operations\VoucherCreate',$oOperation);
        
        $oVoucher = new VoucherInstance();
        
        $oVoucher->setVoucherTypeId(1);
        $oVoucher->setVoucherCode('aaa_01_01');
         
        $this->assertTrue($oOperation->execute($oVoucher));
        
        $this->assertNotEmpty($oVoucher->getVoucherInstanceId());
    }
    
    
}
/* End of class */