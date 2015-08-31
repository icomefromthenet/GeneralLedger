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
            $sAlias.'_'.'voucher_rule_name' => 'voucher A' ,    
            $sAlias.'_'.'voucher_rule_slug' => 'voucher_a' ,    
            $sAlias.'_'.'voucher_gen_rule_id' => 1,
            $sAlias.'_'.'voucher_padding_char' =>'@' ,
            $sAlias.'_'.'voucher_prefix' => 'aprefix',
            $sAlias.'_'.'voucher_suffix' =>'asuffix',
            $sAlias.'_'.'voucher_length' =>100,
            $sAlias.'_'.'date_created' => new DateTime(),
            $sAlias.'_'.'voucher_sequence_strategy' =>'uuid',
        );
        
        $oVoucherRule = $oBuilder->build($aFields);
        
        
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_rule_name'],$oVoucherRule->getVoucherRuleName());
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_rule_slug'],$oVoucherRule->getSlugRuleName());
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_gen_rule_id'],$oVoucherRule->getVoucherGenRuleId());
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_padding_char'],$oVoucherRule->getVoucherPaddingCharacter());
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_prefix'],$oVoucherRule->getVoucherPrefix());
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_suffix'],$oVoucherRule->getVoucherSuffix());
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_length'],$oVoucherRule->getVoucherLength());
        $this->assertEquals($aFields[$sAlias.'_'.'date_created'],$oVoucherRule->getDateCreated());
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_sequence_strategy'],$oVoucherRule->getSequenceStrategyName());
        
        # test demolish
        $aNewFields = $oBuilder->demolish($oVoucherRule);
        
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_rule_name'],$aNewFields['voucher_rule_name']);
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_rule_slug'],$aNewFields['voucher_rule_slug']);
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_gen_rule_id'],$aNewFields['voucher_gen_rule_id']);
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_padding_char'],$aNewFields['voucher_padding_char']);
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_prefix'],$aNewFields['voucher_prefix']);
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_suffix'],$aNewFields['voucher_suffix']);
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_length'],$aNewFields['voucher_length']);
        $this->assertEquals($aFields[$sAlias.'_'.'date_created'],$aNewFields['date_created']);
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_sequence_strategy'],$aNewFields['voucher_sequence_strategy']);
        
    }
    
    
    public function testVoucherInstanceBuilder()
    {
        $oContainer = $this->getContainer();
        
        $oBuilder = $oContainer->getVoucherInstanceGateway()->getEntityBuilder();
        
        $sAlias = $oBuilder->getTableQueryAlias();
        
        $aFields = array(
            $sAlias.'_'.'voucher_instance_id' => 1,    
            $sAlias.'_'.'voucher_type_id' => 1,
            $sAlias.'_'.'voucher_code' => 'prefix_00001_suffix',
            $sAlias.'_'.'date_created' => new DateTime(),
        );
        
        $oVoucherInstance = $oBuilder->build($aFields);
        
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_instance_id'],$oVoucherInstance->getVoucherInstanceId());
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_type_id'],$oVoucherInstance->getVoucherTypeId());
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_code'],$oVoucherInstance->getVoucherCode());
        $this->assertEquals($aFields[$sAlias.'_'.'date_created'],$oVoucherInstance->getDateCreated());
        
        # test demolish
        $aNewFields = $oBuilder->demolish($oVoucherInstance);
        
         
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_instance_id'],$aNewFields['voucher_instance_id']);
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_type_id'],$aNewFields['voucher_type_id']);
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_code'],$aNewFields['voucher_code']);
        $this->assertEquals($aFields[$sAlias.'_'.'date_created'],$aNewFields['date_created']);
       
    }
    
    
    public function testVoucherTypeBuilder()
    {
        
        $oContainer = $this->getContainer();
        
        $oBuilder = $oContainer->getVoucherTypeGateway()->getEntityBuilder();
        
        $sAlias = $oBuilder->getTableQueryAlias();
        
        $aFields = array(
            $sAlias.'_'.'voucher_type_id' => 1,    
            $sAlias.'_'.'voucher_enabled_from' => new DateTime(),
            $sAlias.'_'.'voucher_enabled_to' => new DateTime('now + 5 days'),
            $sAlias.'_'.'voucher_name' => 'example A',
            $sAlias.'_'.'voucher_name_slug' => 'example_a',
            $sAlias.'_'.'voucher_description' => 'This is a really short description',
            $sAlias.'_'.'voucher_group_id' => 1,
            $sAlias.'_'.'voucher_gen_rule_id' => 1
        );
        
        $oVoucherType = $oBuilder->build($aFields);
        
       
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_type_id'],$oVoucherType->getVoucherTypeId());
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_enabled_from'],$oVoucherType->getEnabledFrom());
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_enabled_to'],$oVoucherType->getEnabledTo());
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_name'],$oVoucherType->getName());
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_name_slug'],$oVoucherType->getSlug());
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_description'],$oVoucherType->getDescription());
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_group_id'],$oVoucherType->getVoucherGroupId());
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_gen_rule_id'],$oVoucherType->getVoucherGenRuleId());
      
          # test demolish
        $aNewFields = $oBuilder->demolish($oVoucherType);
        
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_type_id'],$aNewFields['voucher_type_id']);
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_enabled_from'],$aNewFields['voucher_enabled_from']);
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_enabled_to'],$aNewFields['voucher_enabled_to']);
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_name'],$aNewFields['voucher_name']);
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_name_slug'],$aNewFields['voucher_name_slug']);
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_description'],$aNewFields['voucher_description']);
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_group_id'],$aNewFields['voucher_group_id']);
        $this->assertEquals($aFields[$sAlias.'_'.'voucher_gen_rule_id'],$aNewFields['voucher_gen_rule_id']);
      
    }
    
}
/* End of class */