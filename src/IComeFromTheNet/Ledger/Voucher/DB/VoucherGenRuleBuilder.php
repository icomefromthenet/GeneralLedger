<?php
namespace IComeFromTheNet\Ledger\Voucher\DB;

use DBALGateway\Builder\AliasBuilder;

/**
 * Builds Voucher Generator Rules
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class VoucherGenRuleBuilder extends AliasBuilder
{
    /**
      *  Convert data array into entity
      *
      *  @return VoucherGroup
      *  @param array $data
      *  @access public
      */
    public function build($data)
    {
        $oEntity                = new VoucherGenRule();
        $sAlias                 = $this->getTableQueryAlias();
        
        $iVoucherGenId          = $this->getField($data,'voucher_gen_rule_id',$sAlias);
        $sVoucherRuleNameSlug   = $this->getField($data,'voucher_rule_slug',$sAlias);
        $sVoucherRuleName       = $this->getField($data,'voucher_rule_name',$sAlias);
        $sVoucherPaddingCharacter = $this->getField($data,'voucher_padding_char',$sAlias);
        $sVoucherSuffix         = $this->getField($data,'voucher_suffix',$sAlias);
        $sVoucherPrefix         = $this->getField($data,'voucher_prefix',$sAlias);
        $iVoucherLength         = $this->getField($data,'voucher_length',$sAlias);
        $oDateCreated           = $this->getField($data,'date_created',$sAlias);
        $sSequenceStrategy      = $this->getField($data,'voucher_sequence_strategy',$sAlias);
        
        
        $oEntity->setVoucherGenRuleId($iVoucherGenId);
        $oEntity->setSlugRuleName($sVoucherRuleNameSlug);
        $oEntity->setVoucherRuleName($sVoucherRuleName);
        $oEntity->setVoucherPaddingCharacter($sVoucherPaddingCharacter);
        $oEntity->setVoucherSuffix($sVoucherSuffix);
        $oEntity->setVoucherPrefix($sVoucherPrefix);
        $oEntity->setVoucherLength($iVoucherLength);
        $oEntity->setDateCreated($oDateCreated);
        $oEntity->setSequenceStrategyName($sSequenceStrategy);
        
        return $oEntity;
    }
    
    /**
      *  Convert and entity into a data array that match database columns in table
      *
      *  @return array
      *  @access public
      *  @param VoucherGroup    $entity A voucher group entity
      */
    public function demolish($entity)
    {
        $aData = array(
          'voucher_gen_rule_id' => $entity->getVoucherGenRuleId()
         ,'voucher_rule_slug'   => $entity->getSlugRuleName()
         ,'voucher_rule_name'   => $entity->getVoucherRuleName()
         ,'voucher_padding_char'=> $entity->getVoucherPaddingCharacter()
         ,'voucher_suffix'      => $entity->getVoucherSuffix()
         ,'voucher_prefix'      => $entity->getVoucherPrefix()
         ,'voucher_length'      => $entity->getVoucherLength()
         ,'date_created'        => $entity->getDateCreated()
         ,'voucher_sequence_strategy'=> $entity->getSequenceStrategyName()
        );
        
        return $aData;
    }
  
}
/* End of class */