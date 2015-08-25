<?php
namespace IComeFromTheNet\Ledger\Test\Voucher;

use DateTime;
use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use IComeFromTheNet\Ledger\Voucher\DB\VoucherGroup;
use IComeFromTheNet\Ledger\Voucher\DB\VoucherGroupBuilder;

class VoucherBuilderTest extends VoucherTestAbstract
{
    
    public function getDataSet()
    {
       return new ArrayDataSet([
           __DIR__.'/VoucherFixture.php',
        ]);
    }
    
    
    
    public function testVoucherGroupBuilder()
    {
        
        $oContainer = $this->getContainer();
        
        $oBuilder = $oContainer->getVoucherGroupGateway()->getEntityBuilder();
        
        $sAlias = $oBuilder->getTableQueryAlias();
        
        $aFields = array(
           $sAlias.'_voucher_group_id'    =>  1
          ,$sAlias.'_voucher_group_name'  => 'slug name'
          ,$sAlias.'_voucher_group_slug'  => 'slug_name'
          ,$sAlias.'_is_disabled'         => 0
          ,$sAlias.'_sort_order'          => 1
          ,$sAlias.'_date_created'        => new DateTime()
        );
        
        $oVoucherGroup = $oBuilder->build($aFields);
        
        $this->assertEquals($aFields['a_voucher_group_id'],$oVoucherGroup->getVoucherGroupID());
        $this->assertEquals($aFields['a_voucher_group_name'],$oVoucherGroup->getVoucherGroupName());
        $this->assertEquals($aFields['a_voucher_group_slug'],$oVoucherGroup->getSlugName());
        $this->assertEquals((boolean)$aFields['a_is_disabled'],$oVoucherGroup->getDisabledStatus());
        $this->assertEquals($aFields['a_sort_order'],$oVoucherGroup->getSortOrder());
        $this->assertEquals($aFields['a_date_created'],$oVoucherGroup->getDateCreated());
        
        # test demolish
        $aFields = $oBuilder->demolish($oVoucherGroup);
        
        $this->assertEquals($oVoucherGroup->getVoucherGroupID(),$aFields['voucher_group_id']);
        $this->assertEquals($oVoucherGroup->getVoucherGroupName(),$aFields['voucher_group_name']);
        $this->assertEquals($oVoucherGroup->getSlugName(),$aFields['voucher_group_slug']);
        $this->assertEquals($oVoucherGroup->getDisabledStatus(),(boolean)$aFields['is_disabled']);
        $this->assertEquals($oVoucherGroup->getSortOrder(),$aFields['sort_order']);
        $this->assertEquals($oVoucherGroup->getDateCreated(),$aFields['date_created']);
    }
    
    
    public function testVoucherRuleBuilder()
    {
        $oContainer = $this->getContainer();
        
        $oBuilder = $oContainer->getVoucherRuleGateway()->getEntityBuilder();
        
        $sAlias = $oBuilder->getTableQueryAlias();
        
        $aFields = array(
            $sAlias.'_' => '',    
            $sAlias.'_' => '',
            $sAlias.'_' => '',
            $sAlias.'_' => '',
            $sAlias.'_' => '',
        );
        
    }
    
}
/* end of class */