<?php
namespace IComeFromTheNet\Ledger\Voucher\Driver;

use Doctrine\DBAL\Connection;
use IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverInterface;
use IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverFactoryInterface;
use IComeFromTheNet\Ledger\Exception\LedgerException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use IComeFromTheNet\Ledger\Voucher\Event\VoucherEvents;
use IComeFromTheNet\Ledger\Voucher\Event\DriverFactoryEvent;

/**
  *  A Driver Factory for Drivers that power the Sequence Strategy
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class CommonDriverFactory implements SequenceDriverFactoryInterface
{
    
    /**
     * @var array if platform => instance
    */
    protected $factoryInstances;
    
    /*
     * @var Doctrine\DBAL\Connection
     */
    protected $database;
    
    /*
     * @var Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    protected $eventDispatcher;
    
    /**
     *  Class Constructor
     *
     *  @access public
     *  @return void
     *  @param Doctrine\DBAL\Connection $database the database connection
     *
    */
    public function __construct(Connection $database, EventDispatcherInterface $dispatcher)
    {
        $this->database         = $database;
        
        $this->eventDispatcher  = $dispatcher;

        $this->registerDriver('mysql','IComeFromTheNet\\Ledger\\Voucher\\Driver\\MYSQLDriver');
        
    }
    
    
    
    //-------------------------------------------------------
    # SequenceDriverFactoryInterface
    
    
    /**
     * @inhertDoc
    */
    public function registerDriver($platform,$class)
    {
        if(isset($this->factoryInstances[$platform]) === true) {
            throw new LedgerException("Platform $platform already registered with factory");
        }
        
        if(class_exists($class) === false) {
            throw new LedgerException("Platform driver $class does not exist");
        }
        
        $this->factoryInstances[$platform] = $class;
        
        $this->eventDispatcher->dispatch(VoucherEvents::SEQUENCE_DRIVER_REGISTERED,new DriverFactoryEvent($this,$platform,$class));
        
        return $this;
    }
    
    
    /**
     * @inhertDoc
    */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }
    
    
     /**
     * @inhertDoc
    */
    public function getDBAL()
    {
        return $this->database;
    }
    
    
    
    /**
     * @inhertDoc
    */
    public function getInstance($platform,$table)
    {
        if(!isset($this->factoryInstances[$platform])) {
            throw new LedgerException("Platform $platform not registered with factory");
        }
        
        $class = $this->factoryInstances[$platform];
        
        if(is_string($class)) {
            $this->factoryInstances[$platform] = new $class($this->database,$table);    
        }
        

        $this->eventDispatcher->dispatch(VoucherEvents::SEQUNENCE_DRIVER_INSTANCED,
                                             new DriverFactoryEvent($this,
                                                                    $platform,
                                                                    $class,
                                                                    $this->factoryInstances[$platform]
                                                                )
                                            );
        
        return $this->factoryInstances[$platform];
        
    }
}
/* End of Class */
