<?php
namespace IComeFromTheNet\Ledger\Test;

use DateTime;
use DateInterval;
use IComeFromTheNet\Ledger\Entity\AccountGroup;
use IComeFromTheNet\Ledger\Entity\Account;
use IComeFromTheNet\Ledger\Entity\StatementPeriod;


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
        $groupName  = str_repeat('a',151);
        
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
        $groupDescription = str_repeat('a',501);
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
        $accountName = str_repeat('a',151);
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
    
    
    
    
    public function testStatementPeriod()
    {
        $enabled = false;
        $descrption = 'a 120 day statement';
        $name ="a name";
        $period = new StatementPeriod();
        $units = 30;
        $id =1;
        
        # test default value
        $this->assertTrue($period->getEnabled());
        
        # test enabled property
        $period->setEnabled(false);
        $this->assertFalse($period->getEnabled());
        
        # test description
        $period->setDescription($descrption);
        $this->assertEquals($descrption,$period->getDescription());
        
        # test the name
        $period->setName($name);
        $this->assertEquals($name,$period->getName());
        
        # test the period
        $period->setUnits($period);
        $this->assertEquals($units,$period->getUnits());
        
        # test database id
        $period->getStatementPeriodID($id);
        $this->assertEquals($id,$period->getStatementPeriodID());
    }
    
    
    /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage Statement Period enabled flag must be a boolean
     * 
    */ 
    public function testStatementPeriodErrorEnabledNotBoolean()
    {
        $period = new StatementPeriod();
        
        $period->setEnabled('');
    }
    
     /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage Statement Period description must be a string
     * 
    */ 
    public function testStatementPeriodErrorDescriptionNotString()
    {
        $period = new StatementPeriod();
        $period->setDescription(1);
        
    }
    
    
    
    /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage Statement Period description must be between 1 and 255 characters
     * 
    */ 
    public function testStatementPeriodErrorDescriptionEmpty()
    {
        $period = new StatementPeriod();
        $period->setDescription('');
    }
    
     /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage Statement Period description must be between 1 and 255 characters
     * 
    */ 
    public function testStatementPeriodErrorDescriptionTooBig()
    {
        $period = new StatementPeriod();
        $period->setDescription(str_repeat('a',256));
    }
    
    
     /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage Statement Period name must be a string
     * 
    */ 
    public function testStatementPeriodErrorNameNotString()
    {
        $period = new StatementPeriod();
        $period->setName(1);
        
    }
    
    
    
    /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage Statement Statement Period name must be between 1 and 50 characters
     * 
    */ 
    public function testStatementPeriodErrorNameEmpty()
    {
        $period = new StatementPeriod();
        $period->setName('');
    }
    
    /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage Statement Period name must be between 1 and 50 characters
     * 
    */ 
    public function testStatementPeriodErrorNameTooBig()
    {
        $period = new StatementPeriod();
        $period->setName(str_repeat('a',51));
    }
    
  
    /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage Statement Period units must be an integer
     * 
    */ 
    public function testStatementPeriodErrorUnitsNotInteger()
    {
        $period = new StatementPeriod();
        $period->setUnits('');
        
    }
    
    /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage Statement Period units must be an integer > 0
     * 
    */ 
    public function testStatementPeriodErrorUnitsBadRange()
    {
        $period = new StatementPeriod();
        $period->setUnits(0);
        
    }
    
    
    /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage Statement Period id must be an integer
     * 
    */ 
    public function testStatementPeriodErrorIDNotInteger()
    {
        $period = new StatementPeriod();
        $period->setStatementPeriodID('');
        
    }
    
    /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage Statement Period id must be an integer > 0
     * 
    */ 
    public function testStatementPeriodErrorIDBadRange()
    {
        $period = new StatementPeriod();
        $period->setStatementPeriodID(0);
    }
    
    
}
/* End of Class */