<?php
namespace IComeFromTheNet\Ledger\Test\Voucher;

use DateTime;
use IComeFromTheNet\Ledger\Test\Base\TestWithContainer;
use IComeFromTheNet\Ledger\Voucher\VoucherContainer;
use DBALGateway\Feature\BufferedQueryLogger;


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
        $this->oContainer['TestQueryLog'] = new BufferedQueryLogger();
        
        $this->oContainer->getEventDispatcher()->addSubscriber($this->oContainer['TestQueryLog']);
      
    }
   
    return $this->oContainer;
  }
       
}
/* End of File */



