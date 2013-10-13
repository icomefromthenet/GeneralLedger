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
    
    protected $accountingID;
    
    protected $value;
    
    protected $accountName;
    
    
    public function getStatementEntryID()
    {
        
    }
    
    
    public function setStatementEntryID()
    {
        if(!is_init($id)) {
            throw new LedgerException('Statement Entry ID must be an integer');
        }
        
        if($id <= 0) {
            throw new LedgerException('Statement Entry ID must be an integer > 0');
        }
        
    }
    
    
    public function getAccountGroupID()
    {
        
    }
    
    
    public function setAccountGroupID()
    {
        if(!is_init($id)) {
            throw new LedgerException('Statement Entry Account Group ID must be an integer');
        }
        
        if($id <= 0) {
            throw new LedgerException('Statement Entry Account Group ID must be an integer > 0');
        }
        
    }
    
    public function getAccountID()
    {
        
    }
    
    
    public function setAccountID($accountID)
    {
        if(!is_init($id)) {
            throw new LedgerException('Statement Entry Account ID must be an integer');
        }
        
        if($id <= 0) {
            throw new LedgerException('Statement Entry Account ID must be an integer > 0');
        }
        
    }
    
    
    public function getValue()
    {
        
    }
    
    
    public function setValue($value)
    {
        if(!is_numeric($$value)) {
            throw new LedgerException('Statement Entry Account ID must be a numeric');
        }
        
        if($value < 0) {
            throw new LedgerException('Statement Entry Account ID must be an integer => 0');
        }
    }
    
    
    public function getAccountName()
    {
        
    }
    
    public function setAccountName($accountName)
    {
        if(empty($accountName)) {
            
        }
        
        
    }
    
}
/* End of Class */
