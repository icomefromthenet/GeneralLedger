<?php
namespace IComeFromTheNet\Ledger\Event\Voucher;

use Exception;
use Symfony\Component\EventDispatcher\Event;
use IComeFromTheNet\Ledger\Voucher\Strategy\SequenceStrategyInterface;
use IComeFromTheNet\Ledger\Voucher\Strategy\StrategyFactoryInterface;


/**
  *  Event object for events
  *
  *  VoucherEvents::SEQUENCE_STRATEGY_REGISTERED
  *  VoucherEvents::SEQUNENCE_STRATEGY_INSTANCED
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class StrategyFactoryEvent extends Event
{
    protected $factory;
    
    protected $strategy;
    
    protected $strategyName;
    
    protected $className;
   
    public function __construct(StrategyFactoryInterface $factory, $name, $className, SequenceStrategyInterface $strategy = null)
    {
        $this->factory      = $factory;
        $this->strategyName = $name;
        $this->className    = $className;
        $this->strategy     = $strategy;
        
    }
    
    /**
     *  Returns the strategy factory that raised the event
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\Voucher\Strategy\StrategyFactoryInterface
     *
    */
    public function getFactory()
    {
        return $this->factory;        
    }
    
    /**
     *  Returns the strategy name
     *
     *  @access public
     *  @return string
     *
    */
    public function getSrategyName()
    {
        return $this->strategyName;
    }
    
    /**
     *  Gets the driver if instanced
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\Voucher\Strategy\SequenceStrategyInterface
     *
    */
    public function getStrategy()
    {
        return $this->strategy;
    }
    
    /**
     *  Fetch the strategy class name
     *
     *  @access public
     *  @return string the class name
     *
    */
    public function getClassName()
    {
        return $this->className;
    }

}
/* End of Class */



