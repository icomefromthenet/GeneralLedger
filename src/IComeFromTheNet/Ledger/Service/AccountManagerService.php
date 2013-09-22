<?php
namespace IComeFromTheNet\Ledger\Service;

use IComeFromTheNet\Ledger\Entity\Account;
use IComeFromTheNet\Ledger\Entity\AccountGroup;
use IComeFromTheNet\Ledger\DB\AccountGroupGateway;
use IComeFromTheNet\Ledger\DB\AccountGateway;
use IComeFromTheNet\Ledger\Exception\LedgerException;
use DBALGateway\Exception as DBALException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
  *  Manages accounts and account groups
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class AccountManagerService
{
    
    /**
     * @var IComeFromTheNet\Ledger\DB\AccountGroupGateway
    */
    protected $accountGroupGateway;
    
    /**
     *  @var IComeFromTheNet\Ledger\DB\AccountGateway
    */
    protected $accountGateway;
    
    /**
     * @var Symfony\Component\EventDispatcher\EventDispatcherInterface
    */
    protected $eventDispatcher;
    
    /**
     *  Class Constructor
     *
     *  @access public
     *  @return void
     *  @param EventDispatcherInterface $event
     *  @param AccountGroupGateway $accountGroupGateway
     *  @param AccountGateway $accountGateway
     *
    */
    public function __construct(EventDispatcherInterface $event, AccountGroupGateway $accountGroupGateway, AccountGateway $accountGateway)
    {
        $this->accountGroupGateway = $accountGroupGateway;
        $this->accountGateway      = $accountGateway;
        $this->eventDispatcher     = $event;
    }
    
    /**
     *  Open an Account
     *
     *  @access public
     *  @return boolean true if account opened
     *  @param Account $account the account to open
     *  
    */
    public function openAccount(Account $account)
    {
        try {
            
            # has the open and close date been set
            if($account->getDateOpened() === null) {
                throw new LedgerException('Account must have an open date');
            }
            
            if($account->getDateClosed() === null) {
                $dte = new DateTime();
                $dte->setDate(3000,1,1);
                $dte->setTime(0,0,0);
                $account->setDateClosed($dte);
            }
        
            # has there been issued an account number and name
            $accountName   = $account->getAccountName();
            $accountNumber = $account->getAccountNumber();
            
            if(empty($accountName) || empty($accountNumber)) {
                throw new LedgerException('Account must have a unique account number and issued an account name');
            }
            
            $data = $this->accountGateway->getEntityBuilder()->demolish($account);
            $query = $this->accountGateway->insertQuery()->start();
            
            foreach($data as $column => $value) {
                $query->addColumn($column,$value);
            }
                
            $query->end()->insert(); 

        } catch(DBALException $e) {
            throw new LedgerException($e->getMessage(),0,$e);
        }
        
        
    }
    
    /**
     *  Close an account only it it is opened
     *
     *  @access public
     *  @return boolean true if closed
     *  @param Account $account the opened account to close
     *
    */
    public function closeAccount(Account $account)
    {
         try {
            $accountNumber     = $account->getAccountNumber();
            $dateAccountClosed = $account->getDateClosed();
            
            # has the open and close date been set
            if($dateAccountClosed === null) {
                throw new LedgerException('Account must have a closed date');
            }
            
            # check if the account exists
            if(!$currentAccount = $this->findAccount($accountNumber) instanceof Account) {
                throw new LedgerException(sprintf('Can not close account %s as it does not exist',$accountNumber));
            }
            
            # has the account been closed already ie no max date
            if($currentAccount->getDateClosed()->format('Y-m-d') === '3000-01-01' ) {
                throw new LedgerException('Can not close account %s as it has already been closed');
            }
            
            
            return $this->accountGateway
                        ->updateQuery()
                            ->start()
                                ->addColumn('account_date_closed',$dateAccountClosed)
                            ->where()
                                ->filterByAccountNumber($accountNumber)
                            ->end()
                        ->update();

        } catch(DBALException $e) {
            throw new LedgerException($e->getMessage(),0,$e);
        }
    }
    
    /**
     *  Set the group the account is associated with    
     *
     *  @access public
     *  @return boolean true if successful
     *  @param Account $account the account to change
     *  @param AccountGroup $group in which the account should belong
     *
    */
    public function switchAccountToGroup(Account $account,AccountGroup $group)
    {
        try {
         
        # check if account exists
        if(!$currentAccount = $this->findAccount($account->getAccountNumber()) instanceof Account) {
            throw new LedgerException(sprtinf('Unable to verify account %s exists',$account->getAccountNumber()));
        }
         
        # check if account belongs to this group already
        if($currentAccount->getGroupId() === $group->getGroupID()) {
            throw new LedgerException(sprintf('The account %s already belongs with group %s',$currentAccount->getAccountNumber(),$group->getName()));
        }
        
        return $this->accountGateway->updateQuery()
                                        ->start()
                                            ->addColumn('group_id',$group->getGroupID())
                                        ->where()
                                            ->filterByAccountNumber($currentAccount->getAccountNumber())
                                        ->end()
                                    ->update();
        
        } catch(DBALException $e) {
            throw new LedgerException($e->getMessage(),0,$e);
        }
    }
    
    
    /**
     *  Add group to the Ledger
     *
     *  @access public
     *  @return boolean true if added
     *  @param AccountGroup $group the group to add to the ledger
     *
    */
    public function addGroup(AccountGroup $group)
    {
        try {
            
            # check if group exists
            if($group->getGroupID() !== null) {
                throw new LedgerException(sprintf('Group has an identity, can not add an existing group'));
            }
            
            # execute insert
            $data = $this->accountGroupGateway->getEntityBuilder()->demolish($group);
            $query = $this->accountGroupGateway->insertQuery()->start();
            unset($data['group_id']);
            
            foreach($data as $column => $value) {
                $query->addColumn($column,$value);
            }
        
            if($query->end()->insert()) {
                $group->setGroupID($this->accountGroupGateway->lastInsertId());
                return true;
            }
            
            return false;
        
        } catch(DBALException $e) {
            throw new LedgerException($e->getMessage(),0,$e);
        }
    }
    
    
    public function closeGroup(AccountGroup $group)
    {
        try {
            # check if group exists
        if(!$currentGroup = $this->findGroup($group->getGroupID()) instanceof AccountGroup) {
                throw new LedgerException(sprintf('Can not verify group %s at id %s exists',$group->getName(),$group->getGroupID()));
            }
        
        
        } catch(DBALException $e)
        {
            throw new LedgerException($e->getMessage(),0,$e);
        }
    }
    
    /**
     *  Finds a single account using account number
     *
     *  @access public
     *  @return Account
     *  @param integer $accountNumber the account number
     *
    */
    public function findAccount($accountNumber)
    {
        return $this->accountGateway->selectQuery()
                            ->start()
                                ->filterByAccountNumber($accountNumber)
                            ->end()
                            ->findOne();
    }
    
    /**
     *  Find an AccountGroup
     *
     *  @access public
     *  @return AccountGroup
     *  @param integer $groupId the identity of the accountGroup
     *
    */
    public function findGroup($groupId)
    {
        return $this->accountGroupGateway
                    ->selectQuery()
                        ->start()
                            ->filterByGroup($groupId)
                        ->end()
                    ->findOne();
    }
    
    /**
     *  Return the Account QueryBuilder
     *  which can be used to build search query
     *  for accounts
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\Query\AccountQuery
     *
    */
    public function searchAccounts()
    {
        return $this->accountGateway->selectQuery()->start();        
    }
    
    /**
     *  Return Account Group QueryBuilder
     *  where can be used to build search query
     *  for account groups.
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\Query\AccountGroupQuery
     *
    */
    public function searchGroups()
    {
        return $this->accountGroupGateway->selectQuery()->start();
    }
    
    
}
/* End of Class */
