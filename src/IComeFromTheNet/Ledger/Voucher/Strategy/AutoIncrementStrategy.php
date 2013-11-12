<?php
namespace IComeFromTheNet\Ledger\Voucher\Strategy;

use IComeFromTheNet\Ledger\Voucher\SequenceStrategyInterface;
use IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverInterface;

/**
  *  Uses the database to generate a unique identity.
  *
  *  Will use a combination of named sequences and
  *  autoincrement columns. Driver will implement each
  *  solution on a given plaform
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class AutoIncrementStrategy implements SequenceStrategyInterface
{
    
    const STRATEGY_NAME = 'auto';
    
    
    /**
     * @var IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverInterface
    */
    protected $driver;
    
    /**
     *  Class constructor
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
