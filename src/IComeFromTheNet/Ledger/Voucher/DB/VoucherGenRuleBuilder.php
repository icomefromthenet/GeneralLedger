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
        
        
        $entity->setVoucherGenRuleId($iVoucherGenId);
        $entity->setSlugRuleName($sVoucherRuleNameSlug);
        $entity->setVoucherRuleName($sVoucherRuleName);
        $entity->setVoucherPaddingCharacter($sVoucherPaddingCharacter);
        $entity->setVoucherSuffix($sVoucherSuffix);
        $entity->setVoucherPrefix($sVoucherPrefix);
        $entity->setVoucherLength($iVoucherLength);
        $entity->setDateCreated($oDateCreated);
        $entity->setSequenceStrategyName($sSequenceStrategy);
        
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
    
    
    public function validate($oEnity)
    {
        $oValidator = new Validator($this->demolish($entity));
        
        // The fields voucher_padding_char,voucher_suffix,voucher_prefix are not required though expect on of the three
        // to be assigned a value, otherwise why bother with this component.
        
        $oValidator->rule('required',array('voucher_rule_slug','voucher_rule_name','voucher_length','voucher_sequence_strategy'));
        
        // Slug just a pretty version of the name used to remove spaces, so should have same length
        $oValidator->rule('lengthBetween',array('voucher_rule_slug','voucher_rule_name'),1,25);
    
        // padding character is option 
        $oValidator->rule('lengthBetween',array('voucher_padding_char'),0,1);
        
        // Prefix and suffix option and have same max length
        $oValidator->rule('lengthBetween',array('voucher_suffix','voucher_prefix'),0,20);
        
        // This is display length only 3 digits 
        $oValidator->rule('min',array('voucher_length'),2);
        $oValidator->rule('max',array('voucher_length'),100);
        
        $oValidator->rule('in',array('voucher_sequence_strategy'),'seq','uuid');
        
        if( $oValidator->validate()) {
            echo "Yay! We're all good!";
        } else {
            // Errors
            print_r( $oValidator->errors());
        }
    }
}
/* End of class */