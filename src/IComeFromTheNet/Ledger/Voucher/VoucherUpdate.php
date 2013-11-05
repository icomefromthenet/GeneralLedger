<?php
namespace IComeFromTheNet\Ledger\Voucher;

use IComeFromTheNet\Ledger\Entity\VoucherType;
use IComeFromTheNet\Ledger\Service\VoucherService;

/**
  *  Represent a change to voucher properties. Facade is used to
  *  hide properties that can not be changed by a user.
  *
  *  Because: Voucher is a temporal object, changes to properties
  *  require a new entity be registered and the existing
  *  current voucher be closed.
  *
  *  You can only change current Vouchers if vouchers open
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
    
    /**
     *  Class Constructor
     *
     *  @access public
     *  @return void
     *  @param DateTime $processingDate
     *  @param VoucherType $voucher
     *  @param VoucherService $service
     *
    */
    public function __construct(DateTime $processingDate,VoucherType $voucher,$voucher,VoucherService $service)
    {
        $this->voucher        = $voucher;
        $this->processingDate = $processingDate;
        $this->voucherService = $voucherService;
        
    }
    
    
    public function setDescription($description)
    {
        $this->voucher->setDescription($description);
        return $this;
    }
    
    
    public function setSuffix($suffix)
    {
        $this->voucher->setSuffix($suffix);
        return $this;
    }
    
    
    public function setPrefix($prefix)
    {
        $this->voucher->setPrefix($prefix);
        return $this;
    }
    
    
    public function setSequenceStrategy()
    {
        
        return $this;
    }
    
    //-------------------------------------------------------
    
    /**
     *  Calls the service to update this voucher
     *
     *  @access public
     *  @return VoucherService
     *
    */
    public function commit()
    {
        $this->voucherService->addVoucher($this->voucher);
        
    }
    
}
/* End of File */