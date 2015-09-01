<?php
namespace IComeFromTheNet\Ledger\Test\Voucher;

use DateTime;
use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use IComeFromTheNet\Ledger\Voucher\DB\VoucherGroup;
use IComeFromTheNet\Ledger\Voucher\VoucherException;
use IComeFromTheNet\Ledger\Voucher\DB\VoucherGroupBuilder;

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
        
        $oGroup->setVoucherGroupID($iID);
        $oCreateOperation->execute($oGroup);
    }
    
    
    public function testVoucherGroupRevise()
    {
        
        $oContainer = $this->getContainer();
        
        $aOperations = $oContainer->getVoucherGroupOperations();
        
        $oCreateOperation = $aOperations['update'];
        
        # assert correct operation was returned
        $this->assertInstanceOf('\IComeFromTheNet\Ledger\Voucher\Operations\GroupRevise',$oCreateOperation);
        
        $oGroup = new VoucherGroup();
        
        $sName = 'Sales Vouchers';
        $iID   = 1;
        $bDisabled = false;
        $iSort = 100;
        $oCreated = new DateTime();
        $sSlugName = 'sales_vouchers';
        
        $oGroup->setVoucherGroupID($iID);
        $oGroup->setDisabledStatus($bDisabled);
        $oGroup->setVoucherGroupName($sName);
        $oGroup->setSortOrder($iSort);
        $oGroup->setDateCreated($oCreated);
        $oGroup->setSlugName($sSlugName);
        
        
     
    }
    
    public function testVoucherGroupRemove()
    {
        
        $oContainer = $this->getContainer();
        
        $aOperations = $oContainer->getVoucherGroupOperations();
        
        $oCreateOperation = $aOperations['delete'];
        
        # assert correct operation was returned
        $this->assertInstanceOf('\IComeFromTheNet\Ledger\Voucher\Operations\GroupRemove',$oCreateOperation);
        
        
        $oGroup = new VoucherGroup();
        
     
    }
    
}
/* End of class */