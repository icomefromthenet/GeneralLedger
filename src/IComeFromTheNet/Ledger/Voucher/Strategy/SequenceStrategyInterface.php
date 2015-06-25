<?php
namespace IComeFromTheNet\Ledger\Voucher\Strategy;

use IComeFromTheNet\Ledger\Voucher\SequenceInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
  *  A Sequence a class that returns an incrementing value
  *  and implements the SequenceInterface.
  *
  *  An incrementing column / named sequence is not the only
  *  method that can be used to guarantee a unique identity.
  *
  *  A uuid / guid can be used in some situations. 
  *
  *  The job to generate a sequence will be left to a Driver.
  *
  *  Each Strategy has a unique name that be used to identify
  *  it later.
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
interface SequenceStrategyInterface extends SequenceInterface
{

    /**
     *  A class that generates the sequence on a given database platform
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverInterface
     *
    */
    public function getDriver();
    
    /**
     *  Fetch the event dispatcher 
     *
     *  @access public
     *  @return Symfony\Component\EventDispatcher\EventDispatcherInterface
     *
    */
    public function getEventDispatcher();
    
    
    /**
     *  Return a name that can be used to identify which
     *  to use. Don't use a class name, as really bad form
     *  to map to an implementation directly.
     *
     *  @access public
     *  @return void
     *
    */
    public function getStrategyName();
    
}
/* End of Interface */
