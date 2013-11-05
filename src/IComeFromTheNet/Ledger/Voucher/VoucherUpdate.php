<?php
namespace IComeFromTheNet\Ledger\Voucher;

use IComeFromTheNet\Ledger\Entity\VoucherType;
use IComeFromTheNet\Ledger\Service\VoucherService;

/**
  *  Represent a change to voucher properties.
  *
  *  Voucher is a temporal object, changes to properties
  *  require a new entity be registered and the existing
  *  current voucher be closed.
  *
  *  You can only change current Vouchers ir vouchers open
  *  as of the known processing date.
  *
  *  only the following properties can be updated by user
  *
  *  1. Description
  *  2. Suffix
  *  3. Prefix.
  *  4. Sequence Strategy.
  *
  *  The service will load the current entity for editing
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class VoucherUpdate
{
    protected $processingDate;
    
    protected $voucher;
    
    protected $voucherService;
    
    
    protected function validateCurrent(DateTime $processingDate,VoucherType $voucher,VoucherService $service)
    {
        
    }
    
    
    public function __construct(DateTime $processingDate,VoucherType $voucher)
    {
        $this->voucher        = $voucher;
        $this->processingDate = $processingDate;
        
    }
    
    
    public function setDescription()
    {
        
    }
    
    
    public function setSuffix()
    {
        
    }
    
    
    public function setPrefix()
    {
        
    }
    
    
    public function setSequenceStrategy()
    {
        
    }
    
    //-------------------------------------------------------
    
    /**
     *  Freese the updates state by returning the service
     *
     *  @access public
     *  @return VoucherService
     *
    */
    public function freeze()
    {
        return $this->voucherService;
        
    }
    
}
/* End of File */