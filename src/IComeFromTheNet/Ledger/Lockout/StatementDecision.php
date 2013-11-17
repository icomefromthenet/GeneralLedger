<?php
namespace IComeFromTheNet\Ledger\Lockout;

use DateTime;

/**
  *  Will Check if a statement has been run for that
  *  given date. If it has then we have to assume
  *  the resource was locked.
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class StatementDecision implements LockoutDecisionInterface
{
    
    protected $processingDate;
    
    
    protected $statementAPI;
    
    
    public function __construct(DateTime $processingDate, $statementAPI)
    {
        $this->processingDate = $processingDate;
        $this->statementAPI   = $statementAPI;
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
