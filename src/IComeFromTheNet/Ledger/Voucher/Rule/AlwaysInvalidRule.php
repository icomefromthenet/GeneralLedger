<?php
namespace IComeFromTheNet\Ledger\Voucher\Rule;

use IComeFromTheNet\Ledger\Voucher\ValidationRuleInterface;

/**
  *  A Rule that will return invalid to a check.
  *
  *  Used in testing.
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class AlwaysInvalidRule implements ValidationRuleInterface
{
    /**
     *  Validate a voucher reference
     *
     *  @access public
     *  @return boolean true if valid
     *  @param string $voucherReference the reference to validate
     *
    */
    public function validate($voucherReference)
    {
        return false;
    }
    
    /**
     *  Return the validation rules name.
     *
     *  Referend to by voucherType::SetSlugRule()
     *  Referend to by voucherType::getSlugRule()
     *
     *  @access public
     *  @return void
     *
    */
    public function getName()
    {
        return 'always-invalid';
    }
    
    
}
/* End of Class */
