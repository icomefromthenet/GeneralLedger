<?php
namespace IComeFromTheNet\Ledger\Entity;

use DateTime;
use IComeFromTheNet\Ledger\Exception\LedgerException;

/**
  *  Represents each entry in the trial balance
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class StatementEntry
{
    
    protected $statementEntryID;
    
    protected $statementID;
    
    protected $accountGroupID;
    
    protected $accountNumber;
    
    protected $value;
    
    
    /**
     *  Return the database id of this entry
     *
     *  @access public
     *  @return integer the statement id
     *
    */
    public function getStatementEntryID()
    {
        return $this->statementID;
    }
    
    
    /**
     *  Set the database id of this entry
     *
     *  @access public
     *  @return void
     *  @param integer $id
     *
    */
    public function setStatementEntryID($id)
    {
        if(!is_init($id)) {
            throw new LedgerException('Statement Entry ID must be an integer');
        }
        
        if($id <= 0) {
            throw new LedgerException('Statement Entry ID must be an integer > 0');
        }
        
        $this->statementID = $id;
        
    }
    
    /**
     *  docs
     *
     *  @access public
     *  @return void
     *
    */
    public function getAccountGroupID()
    {
        
    }
    
    /**
     *  docs
     *
     *  @access public
     *  @return void
     *
    */
    public function setAccountGroupID($id)
    {
        if(!is_init($id)) {
            throw new LedgerException('Statement Entry account group ID must be an integer');
        }
        
        if($id <= 0) {
            throw new LedgerException('Statement Entry account group ID must be an integer > 0');
        }
        
    }
    
    /**
     *  Fetch the account number this entry represents
     *  If this statement is for a group it could be null
     *
     *  @access public
     *  @return void
     *
    */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }
    
    /**
     *  Sets the account number this entry represents
     *
     *  @access public
     *  @return void
     *  @param integer the account id
     *
    */
    public function setAccountNumber($accountNumber)
    {
        if(!is_init($accountNumber)) {
            throw new LedgerException('Statement Entry account number must be an integer');
        }
        
        if($accountNumber <= 0) {
            throw new LedgerException('Statement Entry account number must be an integer > 0');
        }
        
        $this->accountNumber = $accountNumber;
        
    }
    
    /**
     *  Gets the value of this entry
     *
     *  @access public
     *  @return mixed integer|float|double the value of the entry
     *
    */
    public function getValue()
    {
        return $this->value;        
    }
    
    /**
     *  Sets this entries value
     *
     *  @access public
     *  @return void
     *  @param mixed integer|float|double the value of the entry
     *
    */
    public function setValue($value)
    {
        if(!is_numeric($$value)) {
            throw new LedgerException('Statement Entry Account ID must be a numeric');
        }
        
        if($value < 0) {
            throw new LedgerException('Statement Entry Account ID must be an integer => 0');
        }
        
        $this->value = $value;
    }
    
}
/* End of Class */
