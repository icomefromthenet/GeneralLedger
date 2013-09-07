<?php
namespace IComeFromTheNet\Ledger\Service;

use IComeFromTheNet\Ledger\Entity\Account;
use IComeFromTheNet\Ledger\Entity\AccountGroup;
use IComeFromTheNet\Ledger\DB\AccountGroupGateway;
use IComeFromTheNet\Ledger\DB\AccountGateway;

/**
  *  Manages accounts and account groups
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class AccountManagerService
{
    
    protected $accountGroupGateway;
    
    protected $accountGateway;
    
    public function __construct(AccountGroupGateway $accountGroupGateway, AccountGateway $accountGateway)
    {
        $this->accountGroupGateway = $accountGroupGateway;
        $this->accountGateway      = $accountGateway;
    }
    
    /**
     *  docs
     *
     *  @access public
     *  @return void
     *
    */
    public function open(Account $account, DateTime $now)
    {
        
    }
    
    /**
     *  docs
     *
     *  @access public
     *  @return void
     *
    */
    public function close(Account $account, DateTime $now)
    {
        
    }
    
    /**
     *  docs
     *
     *  @access public
     *  @return void
     *
    */
    public function addToGroup(AccountGroup $group, Account $account)
    {
        
    }
    
    /**
     *  docs
     *
     *  @access public
     *  @return void
     *
    */
    public function removeFromGroup(AccountGroup $group, Account $account)
    {
        
    }
    
    
    public function addGroup(AccountGroup $group, DateTime $now)
    {
        
    }
    
    
    public function closeGroup(AccountGroup $group, DateTime $now)
    {
        
    }
    
    public function findOneAccount()
    {
        
    }
    
    public function findManyAccounts()
    {
        
        
    }
    
    public function findOneGroup()
    {
        
    }
    
    public function findManyGroups()
    {
        
    }
    
    
}
/* End of Class */
