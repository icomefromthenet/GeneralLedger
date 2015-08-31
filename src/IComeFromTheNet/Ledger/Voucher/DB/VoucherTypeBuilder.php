<?php
namespace IComeFromTheNet\Ledger\Voucher\DB;

use DBALGateway\Builder\AliasBuilder;

/**
 * Builds Voucher Types
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class VoucherTypeBuilder extends AliasBuilder
{
    
    /**
      *  Convert data array into entity
      *
      *  @return VoucherType
      *  @param array $data
      *  @access public
      */
    public function build($data)
    {
        
        $oEntity           = new VoucherType();
        $sAlias            = $this->getTableQueryAlias();
        
        $iVoucherTypeId     = $this->getField($data,'voucher_type_id',$sAlias);
        $sName              = $this->getField($data,'voucher_name',$sAlias);
        $sDescription       = $this->getField($data,'voucher_description',$sAlias);
        $oEnableFrom        = $this->getField($data,'voucher_enabled_from',$sAlias);
        $oEnableTo          = $this->getField($data,'voucher_enabled_to',$sAlias);
        $sSlugName          = $this->getField($data,'voucher_name_slug',$sAlias);
        $iVoucherGroupId    = $this->getField($data,'voucher_group_id',$sAlias);
        $iVoucherGenRuleId  = $this->getField($data,'voucher_gen_rule_id',$sAlias);
        
        
        $oEntity->setVoucherTypeId($iVoucherTypeId);
        $oEntity->setEnabledFrom($oEnableFrom);
        $oEntity->setEnabledTo($oEnableTo);
        $oEntity->setName($sName);
        $oEntity->setSlug($sSlugName);
        $oEntity->setDescription($sDescription);
        $oEntity->setVoucherGroupId($iVoucherGroupId);
        $oEntity->setVoucherGenRuleId($iVoucherGenRuleId);
        
        return $oEntity;
        
    }
    
    /**
      *  Convert and entity into a data array that match database columns in table
      *
      *  @return array
      *  @access public
      *  @param VoucherType    $entity A voucher type entity
      */
    public function demolish($entity)
    {
        $aData = array(
            'voucher_type_id'           => $entity->getVoucherTypeId()
            ,'voucher_enabled_from'     => $entity->getEnabledFrom()
            ,'voucher_enabled_to'       => $entity->getEnabledTo()
            ,'voucher_name'             => $entity->getName()
            ,'voucher_name_slug'        => $entity->getSlug()
            ,'voucher_description'      => $entity->getDescription()
            ,'voucher_group_id'         => $entity->getVoucherGroupId()
            ,'voucher_gen_rule_id'      => $entity->getVoucherGenRuleId()
        );
        
        
        return $aData;
    }
    
}
/* End of class */