<?php
namespace IComeFromTheNet\Ledger\Voucher;



/**
 * Voucher
 * 
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0.0
 */ 
class VoucherService
{
    
    /**
     * @var VoucherContainer
     */ 
    protected $container;
    
    
    /**
     * Voucher Service Constructor
     * 
     * @param VoucherContainer $container this modules service container
     * 
     */ 
    public function __construct(VoucherContainer $container)
    {
        $this->container = $container;
        
    }
    
    
    //--------------------------------------------------------------------------
    # Public API
    
    
    public function lookupVoucher()
    {
        
        
    }
    
    
    
    public function expireVoucher()
    {
        
    }
    
    
    public function unexpireVoucher()
    {
        
        
    }
    
    
    public function reviseVoucher()
    {
        
        
    }
    
    
    //--------------------------------------------------------------------------
    # Properties
    
    /**
     * Return the modules service container
     * 
     * @return VoucherContainer
     */ 
    public function getContainer()
    {
       return $this->container; 
    }
  
}
/* End of File /*