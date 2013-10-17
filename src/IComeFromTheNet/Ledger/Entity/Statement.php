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
    
    protected $statementPeriodID;
    
    protected $userID;
    
    protected $orgUnitID;
    
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
     *  Gets the Statement Period ID
     *
     *  @access public
     *  @return integer the statement period database id
     *
    */
    public function getStatementPeriodID()
    {
        return $this->statementPeriodID;
    }
    
    
    /**
     *  Set the statement period ID this used to determine the length
     *  of time this statement run over, used to group statements 
     *  
     *
     *  @access public
     *  @return void
     *  @param integer $id the database id of the StatementPeriod
     *
    */
    public function setStatementPeriodID($id)
    {
        if(is_int($id) === false) {
            throw new LedgerException('A Statement Period ID must be an integer');
        }
        
        $this->statementPeriodID = $id;
    }
    
    /**
     *  Gets the Organisation ID
     *  
     *
     *  @access public
     *  @return integer the database id
     *
    */
    public function getOrgUnitID()
    {
        return $this->orgUnitID;
    }
    
    /**
     *  Sets the Organisation ID which would limit to ledger enteries results for this unit
     *
     *  @access public
     *  @return void
     *  @param integer $id the database ID
     *
    */
    public function setOrgUnitID($id)
    {
        if(is_int($id) === false) {
            throw new LedgerException('A statement organisation id ID must be an integer');
        }
        
        $this->orgUnitID = $id;
    }
    
    /**
     *  Gets the database id of the user
     *
     *  @access public
     *  @return iteger the database id of the user
     *
    */
    public function getUserId()
    {
        return $this->userID;
    }
    
    /**
     *  Sets the statement User Id which would limit to ledger enteries results for this user
     *
     *  @access public
     *  @return void
     *  @param integer $id the database ID
     *
    */
    public function setUserID($id)
    {
        if(is_int($id) === false) {
            throw new LedgerException('A statement user id must be an integer');
        }
        
        $this->userID = $id;
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
