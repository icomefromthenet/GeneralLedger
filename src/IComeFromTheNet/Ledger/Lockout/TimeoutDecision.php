<?php
namespace IComeFromTheNet\Ledger\Lockout;

use DateTime;
use DateInterval;

/**
  *  Will checkout agaist a maximum timout date
  *  for example if you allow changes up to 30 days.
  *
  *  This is useful if your not using statmenets but
  *  want to set a lockout.
  *  
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class TimeoutDecision implements LockoutDecisionInterface
{
    
    protected $processingDate;
    
    protected $timeout;
    
    public function __construct(DateTime $processingDate, DateInterval $timeout)
    {
        $this->processingDate = $processingDate;
        $this->timeout        = $timeout;
    }
    
    
    
    public function getProcessingDate()
    {
        return $this->processingDate;
    }
    
    
    
    public function isUnlocked(DateTime $resourceDate)
    {
        
    }
    
}
/* End of Class */
