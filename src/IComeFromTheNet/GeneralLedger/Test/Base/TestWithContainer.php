<?php
namespace IComeFromTheNet\GeneralLedger\Test\Base;

use DateTime;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Monolog\Logger;
use Monolog\Handler\TestHandler;
use Doctrine\DBAL\Schema\Schema;
use IComeFromTheNet\GeneralLedger\LedgerContainer;
use DBALGateway\Table\GatewayProxyCollection;

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
        $this->oContainer = new LedgerContainer($this->getEventDispatcher(),$this->getDoctrineConnection(),$this->getLogger(), $this->getGatewayProxy());
        $this->oContainer->boot();
        
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
  
  
  protected function getDatabaseSchema()
  {
    return new \Doctrine\DBAL\Schema\Schema();
  }
  
  protected function getGatewayProxy()
  {
    return new GatewayProxyCollection($this->getDatabaseSchema());
  }
 

}
/* End of File */