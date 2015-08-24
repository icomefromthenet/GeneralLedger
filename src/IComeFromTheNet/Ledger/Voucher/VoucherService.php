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
    
    
    public function lookupType()
    {
        
        
    }
    
    
    public function lookupGroup()
    {
    
        
    }
    
    
    public function lookupRule()
    {
    
    
        
    }
    
    
    
    public function expireVoucher()
    {
        
    }
    
    
    public function reverseExpireVoucher()
    {
        
        
    }
    
    
    public function reviseVoucher()
    {
        
        
    }
    
    public function createGroup()
    {
    
        
    }
    
    
    public function removeGroup()
    {
    
        
    }
    
    public function reviseGroup()
    {
    
        
    }
    
    public function createRule()
    {
    
        
    }
    
    
    public function reviseRule()
    {
    
        
    }
    
    
    
    public function instanceVoucher()
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