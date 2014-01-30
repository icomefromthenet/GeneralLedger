<?php
namespace IComeFromTheNet\Ledger\Voucher\Event;

use Exception;
use Symfony\Component\EventDispatcher\Event;
use IComeFromTheNet\Ledger\Voucher\VoucherEntity;

/**
 * Events used inside the voucher service.
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0.0
 */ 
class VoucherServiceEvent extends Event 
{
    
    protected $voucherEntity;
    
    /**
     * Class Constructor
     * 
     * @param VoucherEntity $entity the voucher operation occured on
     */ 
    public function __construct(VoucherEntity $entity) 
    {
        $this->voucherEntity = $entity;
    }
    
    /**
     * Fetch the Voucher 
     * 
     * @return VoucherEntity 
     */ 
    public function getVoucherEntity()
    {
        return $this->voucherEntity;
    }
    
    
}
/* End of Class */