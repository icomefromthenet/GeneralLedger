<?php
namespace IComeFromTheNet\Ledger\Voucher;

/**
  *  Interface for a Voucher Rule
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
interface ValidationRuleInterface
{
    
    /**
     *  Validate a voucher reference
     *
     *  @access public
     *  @return boolean true if valid
     *  @param string $voucherReference the reference to validate
     *
    */
    public function validate($voucherReference);
    
    
}
/* End of Interface */