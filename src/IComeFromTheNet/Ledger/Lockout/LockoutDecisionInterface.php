<?php
namespace IComeFromTheNet\Ledger\Lockout;

use DateTime;

/**
  *  Decsion on wether to allow operations that would
  *  effect ledger history.
  *
  *  The ledger will allow operations for example updates over
  *  reversal and adjustements if the lockout decision returns
  *  false as in not locked.
  *
  *  If a resource fails a lockout test it means that it's
  *  state is history and must remain.
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
interface LockoutDecisionInterface
{
    /**
     *  Return the assigned processing date
     *
     *  @access public
     *  @return DateTime
     *
    */
    public function getProcessingDate();
    
    
    /**
     *  Test if a resource is unlocked ie not
     *  part of the history that must remain.
     *
     *  For example if a statement is run against the ledger
     *  the transactions covered in that run are part of history
     *  can must not be changed.
     *
     *  @access public
     *  @return boolean true if unlocked 
     *
    */
    public function isUnlocked(DateTime $resourceDate);
    
}
/* End of Interface */

