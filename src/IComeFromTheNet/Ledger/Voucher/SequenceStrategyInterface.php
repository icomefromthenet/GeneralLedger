<?php
namespace IComeFromTheNet\Ledger\Voucher;

use IComeFromTheNet\Ledger\Voucher\SequenceInterface;

/**
  *  A Sequence a class that returns an incrementing integer value
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
    
}
/* End of Interface */
