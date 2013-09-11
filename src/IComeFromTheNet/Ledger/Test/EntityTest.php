<?php
namespace IComeFromTheNet\Ledger\Test;

use DateTime;
use DateInterval;
use IComeFromTheNet\Ledger\Entity\AccountGroup;
use IComeFromTheNet\Ledger\Entity\Account;


/**
  *  Unit test of the Entity Objects
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class EntityTest extends \PHPUnit_Framework_TestCase
{
    
    
    
    public function testAccountGroupProperties()
    {
        $groupID    = 1;
        $groupName  = 'gp1';
        $groupDescription = 'the first group';
        $dateAdded   = new DateTime();
        $dateRemoved = new DateTime();
        $dateRemoved->modify('+ 1 day');
        $parentGroup = 1;
        
        $group = new AccountGroup();
        
        $group->setGroupID($groupID);
        $group->setName($groupName);
        $group->setDescription($groupDescription);
        $group->setDateAdded($dateAdded);
        $group->setDateRemoved($dateRemoved);
        $group->setParentGroupID($parentGroup);
        
        $this->assertEquals($groupID,$group->getGroupID());
        $this->assertEquals($groupName,$group->getName());
        $this->assertEquals($groupDescription,$group->getDescription());
        $this->assertEquals($dateAdded,$group->getDateAdded());
        $this->assertEquals($dateRemoved,$group->getDateRemoved());
        $this->assertEquals($parentGroup,$group->getParentGroupID());
    }
    
    
    /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage AccountGroupID must be an integer > 0
     * 
    */  
    public function testErrorAccountGroupNotIntGroupID()
    {
        $groupID    = 'aaa';
        $group = new AccountGroup();
        
        $group->setGroupID($groupID);
        
    }
    
    /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage AccountGroupID must be an integer > 0
     * 
    */ 
    public function testErrorAccountGroupNegativeGroupID()
    {
        $groupID    = -1;
        $group = new AccountGroup();
        
        $group->setGroupID($groupID);
        
    }
    
    /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage Group Name must be a string < 150 characters
     * 
    */ 
    public function testErrorAccountGroupEmptyName()
    {
        $groupName  = '';
        $group = new AccountGroup();
        $group->setName($groupName);
    }
    
    /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage Group Name must be a string < 150 characters
     * 
    */ 
    public function testErrorAccountGroupNameExceedsLimit()
    {
        $groupName  = str_repeat('a',100);
        
        $group = new AccountGroup();
        $group->setName($groupName);
    }
    
    /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage Group Description must be a string < 500 characters
     * 
    */ 
    public function testErrorAccountGroupDescriptionEmpty()
    {
        $groupDescription = '';
        $group = new AccountGroup();
        $group->setDescription($groupDescription);
    }
    
    /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage Group Description must be a string < 500 characters
     * 
    */ 
    public function testErrorAccountGroupDescriptionExceedsLimit()
    {
        $groupDescription = str_repeat('a',151);
        $group = new AccountGroup();
        $group->setDescription($groupDescription);
    }
    
    
    public function testAccountProperties()
    {
        $account = new Account();
        
        $accountNumber = 1;
        $accountName = 'payments account';
        $accountGroup = 1;
        $dateOpened = new DateTime();
        $dateClosed = new DateTime();
        $dateClosed->modify('+1 day');
        
        $account->setAccountName($accountName);
        $account->setAccountNumber($accountNumber);
        $account->setDateOpened($dateOpened);
        $account->setDateClosed($dateClosed);
        $account->setGroupId($accountGroup);
        
        
        $this->assertEquals($accountGroup,$account->getGroupId());
        $this->assertEquals($accountName,$account->getAccountName());
        $this->assertEquals($accountNumber,$account->getAccountNumber());
        $this->assertEquals($dateOpened,$account->getDateOpened());
        $this->assertEquals($dateClosed,$account->getDateClosed());
        
        
    }
    
    /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage Account number must be an integer > 0
     * 
    */ 
    public function testErrorAccountNumberNotInteger()
    {
        $account = new Account();
        $accountNumber = 'a';
        $account->setAccountNumber($accountNumber);
    }
    
    /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage Account number must be an integer > 0
     * 
    */ 
    public function testErrorAccountNumberNegative()
    {
        $account = new Account();
        $accountNumber = -1;
        $account->setAccountNumber($accountNumber);
    }
    
    
    /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage Account Name must be a string < 150 characters
     * 
    */ 
    public function testErrorAccountNameEmpty()
    {
        $account = new Account();
        $accountName = '';
        $account->setAccountName($accountName);
    }
    
    /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage Account Name must be a string < 150 characters
     * 
    */ 
    public function testErrorAccountNameExceedsSizeLimit()
    {
        $account = new Account();
        $accountName = str_repeat('a',51);
        $account->setAccountName($accountName);
    }
    
    /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage The account Group ID must be > 0
     * 
    */ 
    public function testErrorAccountGroupIDNegative()
    {
        $account = new Account();
        $groupID = 0;
        
        $account->setGroupID($groupID);
        
    }
    
    /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage Date the account closed must be after the set opening date
     * 
    */ 
    public function testErrorAccountDateClosedOccursBeforeOpen()
    {
         $account = new Account();
        
        $dateOpened = new DateTime();
        $dateClosed = new DateTime();
        
    
        
        $account->setDateOpened($dateOpened);
        $account->setDateClosed($dateClosed);
        
    }
    
    /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage Date the account opened must be before the set closed date
     * 
    */ 
    public function testErrorAccountDateOpenedOccursAfterClose()
    {
        $account = new Account();
        
        $dateOpened = new DateTime();
        $dateClosed = new DateTime();
        
    
        $account->setDateClosed($dateClosed);
        $account->setDateOpened($dateOpened);
        
    }
    
    
    
    
}
/* End of Class */