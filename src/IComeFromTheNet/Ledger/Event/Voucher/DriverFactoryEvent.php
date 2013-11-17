<?php
namespace IComeFromTheNet\Ledger\Event\Voucher;

use Exception;
use Symfony\Component\EventDispatcher\Event;
use IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverFactoryInterface;
use IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverInterface;

/**
  *  Event object for events
  *
  *  VoucherEvents::SEQUNENCE_DRIVER_INSTANCED
  *  VoucherEvents::SEQUENCE_DRIVER_REGISTERED
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class DriverFactoryEvent extends Event
{
    protected $factory;
    
    protected $driver;
    
    protected $driverName;
    
    protected $platform;
   
    public function __construct(SequenceDriverFactoryInterface $factory, $platform, $driverName, SequenceDriverInterface $driver = null)
    {
        $this->factory      = $factory;
        $this->platform     = $platform;
        $this->driverName   = $driverName;
        $this->driver       = $driver;
    }
    
    /**
     *  Returns the driver factory that raised the event
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverInterface
     *
    */
    public function getFactory()
    {
        return $this->factory;        
    }
    
    /**
     *  Returns the driver name
     *
     *  @access public
     *  @return string
     *
    */
    public function getDriverName()
    {
        return $this->driverName;
    }
    
    /**
     *  Gets the driver if instanced
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverFactoryInterface
     *
    */
    public function getDriver()
    {
        return $this->driver;
    }
    
    /**
     *  Gets the name of the database platform the driver supports
     *
     *  @access public
     *  @return string the plaform name
     *
    */
    public function getPlatform()
    {
        return $this->platform;   
    }

}
/* End of Class */



