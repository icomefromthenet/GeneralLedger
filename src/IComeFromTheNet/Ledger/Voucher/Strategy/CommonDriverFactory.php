<?php
namespace IComeFromTheNet\Ledger\Voucher\Strategy;

use Doctrine\DBAL\Connection;
use IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverInterface;
use IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverFactoryInterface;
use IComeFromTheNet\Ledger\Exception\LedgerException;

/**
  *  A Driver Factory for Drivers that power the UUID Sequence Strategy
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class CommonDriverFactory implements  SequenceDriverFactoryInterface
{
    
    /**
     * @var array if platform => instance
    */
    protected $factoryInstances;
    
    /*
     * @var Doctrine\DBAL\Connection
     */
    protected $database;
    
    
    /**
     *  Class Constructor
     *
     *  @access public
     *  @return void
     *  @param Doctrine\DBAL\Connection $database the database connection
     *
    */
    public function __construct(Connection $database)
    {
        $this->database = $database;
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
        
        return $this;
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
    public function getInstance($platform)
    {
        if(isset($this->factoryInstances[$platform]) === true) {
            throw new LedgerException("Platform $platform not registered with factory");
        }
        
        if(!$class instanceof SequenceDriverInterface ) {
            $class = $this->factoryInstances[$platform];
            $this->factoryInstances[$platform] = new $class($this->database);
        }
        
        return $this->factoryInstances[$platform];
        
    }
}
/* End of Class */
