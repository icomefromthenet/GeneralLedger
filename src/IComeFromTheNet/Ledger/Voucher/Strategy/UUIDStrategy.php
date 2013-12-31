<?php
namespace IComeFromTheNet\Ledger\Voucher\Strategy;

use IComeFromTheNet\Ledger\Voucher\Strategy\SequenceStrategyInterface;
use IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use IComeFromTheNet\Ledger\Voucher\Event\VoucherEvents;
use IComeFromTheNet\Ledger\Voucher\Event\SequenceEvent;

/**
  *  Generates a unique identity using UUID functions
  *
  *  This strategy rely on database to make a unique identity.
  *
  *  Not use sequences or auto increment columns
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class UUIDStrategy implements SequenceStrategyInterface
{
 
    const STRATEGY_NAME = 'uuid';
    
    /*
     * @var IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverInterface
     */
    protected $driver;
    
    /*
     * @var Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    protected $event;
    
    /**
     *  Class Constructor
     *
     *  @access public
     *  @return void
     *  @param SequenceDriverInterface $driver the database driver
     *  @param EventDispatcherInterface $dispatcher the event dispatcher
     *
    */
    public function __construct(SequenceDriverInterface $driver, EventDispatcherInterface $event)
    {
        $this->driver = $driver;
        $this->event  = $event;
    }
    
    //-------------------------------------------------------
    # SequenceStrategyInterface
    
    
    /*
     * @inheritDoc
     */
    public function getDriver()
    {
        return $this->driver;
    }
    
    /**
     *  Fetch the event dispatcher 
     *
     *  @access public
     *  @return Symfony\Component\EventDispatcher\EventDispatcherInterface
     *
    */
    public function getEventDispatcher()
    {
        return $this->event;
    }
   
   
    /*
     * @inheritDoc
     */
    public function getStrategyName()
    {
        return self::STRATEGY_NAME;
    }
    
    
    
    /*
     * Generate an incrementing value
     *
     * @access public
     * @return integer|string a sequence value
     * @param string $sequenceName the sequence name
     *
     */
    public function nextVal($sequenceName)
    {
        $this->getEventDispatcher()->dispatch(VoucherEvents::SEQUENCE_BEFORE, new SequenceEvent($this,$this->getDriver()));
            $seq =  $this->getDriver()->uuid($sequenceName);
        $this->getEventDispatcher()->dispatch(VoucherEvents::SEQUENCE_AFTER,new SequenceEvent($this,$this->getDriver(),$seq));
        
        return $seq;
    }
    
}
/* End of Class */
