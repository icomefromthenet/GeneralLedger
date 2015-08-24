<?php
namespace IComeFromTheNet\Ledger\Test\Voucher;

use DateTime;
use IComeFromTheNet\Ledger\Test\Base\TestWithContainer;
use IComeFromTheNet\Ledger\Voucher\VoucherContainer;

abstract class VoucherTestAbstract extends TestWithContainer
{
    
  /**
   *  Return an instance of the container
   *
   *  @access public
   *  @return IComeFromTheNet\Ledger\Voucher\VoucherContainer
   *
  */
  public function getContainer()
  {
    if(isset($this->oContainer) === false) {
        $this->oContainer = new VoucherContainer($this->getDoctrineConnection(),$this->getEventDispatcher(),$this->getLogger(),$this->getGatewayProxyCollection());
        $this->oContainer->boot($this->getNow());
        
        # register test services
        
      
    }
   
    return $this->oContainer;
  }
       
}
/* End of File */



