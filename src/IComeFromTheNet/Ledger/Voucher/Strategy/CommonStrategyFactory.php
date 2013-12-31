<?php
namespace IComeFromTheNet\Ledger\Voucher\Strategy;

use IComeFromTheNet\Ledger\Voucher\Strategy\StrategyFactoryInterface;
use IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverFactoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use IComeFromTheNet\Ledger\Exception\LedgerException;
use IComeFromTheNet\Ledger\Voucher\Event\VoucherEvents;
use IComeFromTheNet\Ledger\Voucher\Event\StrategyFactoryEvent;
use IComeFromTheNet\Ledger\Voucher\Strategy\SequenceStrategyInterface;
use IComeFromTheNet\Ledger\Voucher\Strategy\AutoIncrementStrategy;
use IComeFromTheNet\Ledger\Voucher\Strategy\UUIDStrategy;

/**
  *  Factory that builds Sequence Strategies
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class CommonStrategyFactory implements StrategyFactoryInterface
{
    
    protected $strategyInstances = array();
    
    protected $eventDispatcher;
    
    protected $driverFactory;
    
    
    /**
     *  Class Constructor
     *
     *  @access public
     *  @return void
     *  @param SequenceDriverFactoryInterface $driverFactory
     *  @param EventDispatcherInterface $dispatcher
     *
    */
    public function __construct(SequenceDriverFactoryInterface $driverFactory, EventDispatcherInterface $dispatcher)
    {
        $this->driverFactory     = $driverFactory;
        $this->eventDispatcher   = $dispatcher;
        $this->strategyInstances = array();
        
        $this->registerStrategy('sequence','IComeFromTheNet\\Ledger\\Voucher\\Strategy\\AutoIncrementStrategy');
        $this->registerStrategy('uuid','IComeFromTheNet\\Ledger\\Voucher\\Strategy\\UUIDStrategy');
    }
    
    
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
    public function registerStrategy($name,$class)
    {
        if(isset($this->strategyInstances[$name])) {
            throw new LedgerException("Sequence strategy $name already registered with factory");
        }
        
        if(class_exists($class) === false) {
            throw new LedgerException("Sequence strategy $class does not exist");
        }
        
        $this->strategyInstances[$name] = $class;
        
        $this->getEventDispatcher()->dispatch(VoucherEvents::SEQUENCE_STRATEGY_REGISTERED,new StrategyFactoryEvent($this,$name,$class));
        
        return $this;
    }
    
    
    /**
     *  Factory that loads database drivers
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverFactoryInterface
     *
    */
    public function getDriverFactory()
    {
        return $this->driverFactory;
    }
    
    
    /**
     *  Load the Event Dispatcher
     *
     *  @access public
     *  @return  Symfony\Component\EventDispatcher\EventDispatcherInterface;
     *
    */ 
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }
   
    
    
    /**
     *  Create and instance of a strategy
     *
     *  @access public
     *  @return SequenceStrategyInterface
     *  @param string $name     SequenceStrategyInterface::getStrategyName()
     *  @param string $platform SequenceDriverInterface::getPlatform()
    */
    public function getInstance($name,$platform)
    {
        if(isset($this->strategyInstances[$name]) === true) {
            throw new LedgerException("Sequence strategy $name not registered with factory");
        }
        
        if(!$class instanceof SequenceStrategyInterface ) {
            
            $class = $this->strategyInstances[$name];
            $this->factoryInstances[$name] = new $class($this->getDriverFactory()->getInstance($platform),$this->getEventDispatcher());
            
            $this->getEventDispatcher()->dispatch(VoucherEvents::SEQUNENCE_STRATEGY_INSTANCED,
                                             new StrategyFactoryEvent($this,
                                                                      $name,
                                                                      $class,
                                                                      $this->factoryInstances[$platform]
                                                                    )
                                            );
        }
        
        return $this->factoryInstances[$name];
    }
    
}
/* End of Class */
