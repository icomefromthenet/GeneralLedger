<?php
namespace IComeFromTheNet\Ledger\Service;

use IComeFromTheNet\Ledger\Voucher\ValidationRuleBag;
use IComeFromTheNet\Ledger\Entity\VoucherType;
use IComeFromTheNet\Ledger\Voucher\VoucherUpdate;

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
  *  This service hide the temporal nature of the entity.
  *  Updating an entity requires closing current entity and
  *  change it to reference new created entity.
  *
  *  Some fields like description do not require a temporal update
  *  and will just update the current voucher type.
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class VoucherService
{
    
    protected $ruleBag;
    protected $processingDate;
    
    
    protected function validityCheck(VoucherType $voucherType)
    {
        
    }
    
    
    public function __construct(ValidationRuleBag $ruleBag,DateTime $processingDate)
    {
        $this->ruleBag        = $ruleBag;
        $this->processingDate = $processingDate;
    }
    
    
    //-------------------------------------------------------
    # CRUD Services
    
    /**
     *  Add a new Voucher Type.
     *
     *  Assign database id to the entity if sucessful
     *
     *  @access public
     *  @return boolean true if voucher added sucessfuly
     *
    */
    public function addVoucher(VoucherType $voucherType)
    {
        # check if been assigned a DB ID already
        
        # check if this voucher exists but for a different
        # validity date range
        
        # If exists does this new record overlap? (throw exception)
        
    }
    
    
    /**
     *  Close a Voucher Type by setting validity date to the
     *  supplied value in the object.
     *
     *  @access public
     *  @return boolean true if successful
     *  @param VoucherType $voucherType
     *
    */
    public function closeVoucher(VoucherType $voucherType)
    {
        
        
    }
    
    /**
     *  This will allow the voucher type to be updated with new
     *  values, to ensure consistency the current object will be
     *  loaded to provide the base.
     *
     *  A facade VoucherUpdate provides the interface, the
     *  service store single update an clear when committed 
     *
     *  @access public
     *  @return void
     *
    */
    public function startUpdateVoucher($voucherSlugName)
    {
        # load most current voucher
        
        # instance update
        //$v = 
        
        
        return VoucherUpdate($this->processingDate,$v,$this);
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
