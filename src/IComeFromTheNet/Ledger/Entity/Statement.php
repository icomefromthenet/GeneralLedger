<?php
namespace IComeFromTheNet\Ledger\Entity;

use DateTime;
use IComeFromTheNet\Ledger\Exception\LedgerException;

/**
  *  Trial balance saved for later reference
  *  the aggregate value of each accounting group / account is
  *  saved as a statementEntry. 
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class Statement
{
    
    protected $statementID;
    
    protected $runDate;
    
    protected $periodStart;
    
    protected $periodFinish;
    
    /**
     *  Gets the statementID
     *
     *  @access public
     *  @return integer this statement id
     *
    */    
    public function getStatementID()
    {
        return $this->statementID;
    }
    
    /**
     *  Sets the statement ID
     *
     *  @access public
     *  @param integer $id this statements unique id
     *
    */
    public function setStatementID($id)
    {
        if(!is_init($id)) {
            throw new LedgerException('Statement ID must be an integer');
        }
        
        if($id <= 0) {
            throw new LedgerException('Statement ID must be an integer > 0');
        }
        
        $this->statementID = $id;
    }
    
    /**
     *  Gets the date the statement was run     
     *
     *  @access public
     *  @return DateTime
     *
    */
    public function getRunDate()
    {
        return $this->runDate;
    }
    
    /**
     *  Sets the date this statement was run
     *
     *  @access public
     *  @return void
     *  @param DateTime $rundate the report run date
     *
    */
    public function setRunDate(DateTime $runDate)
    {
        $this->runDate = $runDate;
    }
    
    /**
     *  Get the first date that this statement covers     
     *
     *  @access public
     *  @return DateTime the start date this statement covers
     *
    */
    public function getPeriodStart()
    {
        return $this->periodStart;
    }
    
    /**
     *  Sets the first date this statement covers
     *
     *  @access public
     *  @return void
     *
    */
    public function setPeriodStart(DateTime $periodStart)
    {
        $this->periodStart = $periodStart;
    }
    
    /**
     *  Get the last date that this statement covers
     *
     *  @access public
     *  @return void
     *
    */
    public function getPeriodEnd()
    {
        return $this->periodFinish;
    }
    
    /**
     *  The last date that this statement covers
     *
     *  @access public
     *  @return DateTime set the end date
     *
    */
    public function setPeriodEnd(DateTime $periodFinish)
    {
        $this->periodFinish = $periodFinish;
    }
    
    
}
/* End of Class */
