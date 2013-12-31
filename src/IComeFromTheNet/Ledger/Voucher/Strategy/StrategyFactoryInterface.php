<?php
namespace IComeFromTheNet\Ledger\Voucher\Strategy;

use IComeFromTheNet\Ledger\Voucher\Strategy\SequenceStrategyInterface;
use IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverFactoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
  *  Implements Factory Behaviour to load sequence strategies
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
interface StrategyFactoryInterface
{
    
    /**
     *  Register a driver instance class
     *  The driver will be lazy loaded
     *
     *  @access public
     *  @return StrategyFactoryInterface
     *  @param string $name  SequenceStrategyInterface::getStrategyName() 
     *  @param string $class a fully qualified name of class
     *
    */
    public function registerStrategy($name,$class);
    
    
    /**
     *  Factory that loads database drivers
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverFactoryInterface
     *
    */
    public function getDriverFactory();
    
    
    /**
     *  Load the Event Dispatcher
     *
     *  @access public
     *  @return  Symfony\Component\EventDispatcher\EventDispatcherInterface;
     *
    */ 
    public function getEventDispatcher();
   
    
    
    /**
     *  Create and instance of a strategy
     *
     *  @access public
     *  @return SequenceStrategyInterface
     *  @param string $name     SequenceStrategyInterface::getStrategyName()
     *  @param string $platform SequenceDriverInterface::getPlatform()
    */
    public function getInstance($name,$platform);
    
}
/* End of Interface */
