<?php
namespace IComeFromTheNet\Ledger\Service;

use IComeFromTheNet\Ledger\Voucher\ValidationRuleBag;
use IComeFromTheNet\Ledger\Entity\VoucherType;

/**
  *  Service to manage and validate vouchers.
  *
  *  Ledger Transaction can often be classfied into
  *  discrete groups like:
  *
  *  1. Invoices
  *  2. General Journals
  *  3. Sales Recepits
  *  4. etc...
  *
  *  This service allows the definition of custom voucher types.
  *
  *  Ledger Transaction often result from activites, vouchers
  *  are a system to have categories for these activites and
  *  provide unique identifiers for each activity.
  *
  *  A Voucher has a unique identifer called a voucher reference
  *  which can be validated using rules registered with the ValidationRuleBag.
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class VoucherService
{
    
    protected $ruleBag;
    
    
    
    public function __construct(ValidationRuleBag $ruleBag)
    {
        $this->ruleBag = $ruleBag;
    }
    
    
    //-------------------------------------------------------
    # CRUD Services
    
    public function addVoucher(VoucherType $vouchertype)
    {
        
    }
    
    
    
    
    
    //-------------------------------------------------------
    # Voucher Validation 
    
    /**
     *  docs
     *
     *  @access public
     *  @return void
     *
    */
    public function validateReference($voucherReference,$voucherSlug)
    {
        
    }
    
    /**
     *  docs
     *
     *  @access public
     *  @return void
     *
    */
    public function getValidationRuleBag()
    {
        return $this->ruleBag;
    }
    
    
}
/* End of Class */
