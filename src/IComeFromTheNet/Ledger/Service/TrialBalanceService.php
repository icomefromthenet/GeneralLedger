<?php
namespace IComeFromTheNet\Ledger\Service;

use DateTime;

/**
  *  Service to store Trial Balances (Statements)
  *
  *  A Trail Balance is a collection of AccountBalances
  *  and is known as a statement.
  *
  *  AccountBalance will have meta information about
  *  the account it represents, including the account name
  *  and the name of the account group and their database id's.
  *
  *  Using the statement alone you can print Balance Sheets
  *  and Profit and Loss.
  *
  *  A Statement uses a Date with smallest granularity being a day. 
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class TrialBalanceService
{
    
    
    
    
    public function createStatement()
    {
        
    }
    
    
    public function findOneStatement($id)
    {
        
    }
    
    
    public function findManyStatements()
    {
        
    }
    
    /**
     *  Delete old Statements that run before given date
     *
     *  @access public
     *  @return integer number of deleted statements
     *  @param DateTime $before a date 
     *
    */
    public function archiveStatements(DateTime $before)
    {
        
    }
    
}
/* End of Class */