<?php
namespace IComeFromTheNet\Ledger\Test\Base;

use DateTime;
use IComeFromTheNet\Ledger\Service\LedgerServiceProvider;
use IComeFromTheNet\Ledger\GatewayProxyCollection;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Monolog\Logger;
use Monolog\Handler\TestHandler;
use Doctrine\DBAL\Schema\Schema;

class TestWithContainer extends TestWithFixture
{
    
  protected $oContainer;
  
  
  /**
   *  Return an instance of the container
   *
   *  @access public
   *  @return IComeFromTheNet\Ledger\Service\LedgerServiceProvider
   *
  */
  public function getContainer()
  {
    if(isset($this->oContainer) === false) {
        $this->oContainer = new LedgerServiceProvider($this->getEventDispatcher(),$this->getDoctrineConnection(),$this->getLogger());
        $this->oContainer->boot($this->getNow());
        
        # register test services
        
      
    }
   
    return $this->oContainer;
  }
  
  /**
   *  docs
   *
   *  @access public
   *  @return Psr\Log\LoggerInterface
   *
  */
  
  protected function getLogger()
  {
     return new Logger('test-ledger',array(new TestHandler()));
  }
  
  /**
   *  Loads an eventdispatcher
   *
   *  @access protected
   *  @return Symfony\Component\EventDispatcher\EventDispatcherInterface
   *
  */
  protected function getEventDispatcher()
  {
    return new EventDispatcher();
  }
  
  /**
   *  Return a dateTime object
   *  Children Tests that want to bootstrap with
   *  fixed date should override this class
   *
   *  @access protected
   *  @return DateTime
   *
  */
  protected function getNow()
  {
    return new DateTime();
  }
  
 /**
  * Return the Gateway Proxy Collection
  * 
  * @return IComeFromTheNet\Ledger\GatewayProxyCollection
  */ 
  protected function getGatewayProxyCollection()
  {
    $schema = new Schema();
    
    return new GatewayProxyCollection($schema);
  }

}
/* End of File */