<?php
namespace IComeFromTheNet\Ledger\Voucher\Strategy;

use IComeFromTheNet\Ledger\Voucher\SequenceStrategyInterface;
use IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverInterface;

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
    
    
    /**
     *  Class Constructor
     *
     *  @access public
     *  @return void
     *  @param SequenceDriverInterface $driver the database driver
     *
    */
    public function __construct(SequenceDriverInterface $driver)
    {
        $this->driver = $driver;
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
    
   
    /*
     * @inheritDoc
     */
    public function getStrategyName()
    {
        return $self::STRATEGY_NAME;
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
        return $this->getDriver()->nextVal($sequenceName);
    }
    
}
/* End of Class */
