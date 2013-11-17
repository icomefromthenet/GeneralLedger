<?php
namespace IComeFromTheNet\Ledger\Lockout;

use DateTime;

/**
  *  Will always return a resource as unlocked.
  *  Used to force simple mode operation
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class UnlimitedDecision implements LockoutDecisionInterface
{
    
    protected $processingDate;
    
    
    public function __construct(DateTime $processingDate)
    {
        $this->processingDate = $processingDate;
    }
    
    
    
    public function getProcessingDate()
    {
        return $this->processingDate;
    }
    
    
    
    public function isUnlocked(DateTime $resourceDate)
    {
        return true;
    }
    
}
/* End of Class */
