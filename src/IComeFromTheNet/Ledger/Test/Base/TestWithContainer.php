<?php
namespace IComeFromTheNet\Ledger\Test\Base;

use DateTime;
use IComeFromTheNet\Ledger\Service\LedgerServiceProvider;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Monolog\Logger;
use Monolog\Handler\TestHandler;

class TestWithContainer extends TestWithFixture
{
    
  static $container;
  
  
  /**
   *  Return an instance of the container
   *
   *  @access public
   *  @return IComeFromTheNet\Ledger\Service\LedgerServiceProvider
   *
  */
  public function getContainer()
  {
    if(isset(self::$container) === false) {
        self::$container = new LedgerServiceProvider($this->getEventDispatcher(),$this->getDoctrineConnection(),$this->getLogger());
        self::$container->boot($this->getNow());
        
        # register test services
        
        self::$container['mock_temportal_gateway'] = self::$container->share(function($c){
           
           $meta    = \IComeFromTheNet\Ledger\Test\Base\MockGateway::getTableMetaData();
           $builder = \IComeFromTheNet\Ledger\Test\Base\MockBuilder();
           
           return new \IComeFromTheNet\Ledger\Test\Base\MockGateway('mock_temportal',
                                                                $c->getDoctrineDBAL(),
                                                                $c->getEventDispatcher(),
                                                                $meta,
                                                                null,
                                                                $builder
                                                                );
        });
    }
   
    return self::$container;
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

}
/* End of File */