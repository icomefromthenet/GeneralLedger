<?php
namespace IComeFromTheNet\Ledger\Test;

use DateTime;
use DateInterval;
use IComeFromTheNet\Ledger\Entity\AccountGroup;
use IComeFromTheNet\Ledger\Entity\Account;
use IComeFromTheNet\Ledger\Entity\StatementPeriod;
use IComeFromTheNet\Ledger\Entity\OrganisationUnit;


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
        
        
        $group = new AccountGroup();
        
        $group->setGroupID($groupID);
        $group->setGroupName($groupName);
        $group->setGroupDescription($groupDescription);
        $group->setDateAdded($dateAdded);
        $group->setDateRemoved($dateRemoved);
        
        
        $this->assertEquals($groupID,$group->getGroupID());
        $this->assertEquals($groupName,$group->getGroupName());
        $this->assertEquals($groupDescription,$group->getGroupDescription());
        $this->assertEquals($dateAdded,$group->getDateAdded());
        $this->assertEquals($dateRemoved,$group->getDateRemoved());
        
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
        $group->setGroupName($groupName);
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
        $group->setGroupName($groupName);
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
        $group->setGroupDescription($groupDescription);
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
        $group->setGroupDescription($groupDescription);
    }
    
    
     /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage Date the group removed must be after the set added date
     * 
    */ 
    public function testErrorAccountGroupDateRemovedOccursBeforeAdded()
    {
         $account = new AccountGroup();
        
        $dateOpened = new DateTime();
        $dateClosed = clone $dateOpened;
        
    
        
        $account->setDateAdded($dateOpened);
        $account->setDateRemoved($dateClosed);
        
    }
    
    /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage Date the group added must be before the set removal date
     * 
    */ 
    public function testErrorAccountGroupDateAddedOccursAfterRemoval()
    {
        $account = new AccountGroup();
        
        $dateOpened = new DateTime();
        $dateClosed = clone $dateOpened;
        
    
        $account->setDateRemoved($dateClosed);
        $account->setDateAdded($dateOpened);
        
    }
    
    public function testAccountProperties()
    {
        $account = new Account();
        
        $accountNumber = 1;
        $accountName = 'payments account';
        $dateOpened = new DateTime();
        $dateClosed = new DateTime();
        $dateClosed->modify('+1 day');
        
        $account->setAccountName($accountName);
        $account->setAccountNumber($accountNumber);
        $account->setDateOpened($dateOpened);
        $account->setDateClosed($dateClosed);
        
        
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
     * @expectedExceptionMessage Date the account closed must be after the set opening date
     * 
    */ 
    public function testErrorAccountDateClosedOccursBeforeOpen()
    {
         $account = new Account();
        
        $dateOpened = new DateTime();
        $dateClosed = clone $dateOpened;
        
    
        
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
        $dateClosed = clone $dateOpened;
        
    
        $account->setDateClosed($dateClosed);
        $account->setDateOpened($dateOpened);
        
    }
    
    
   
    
    //public function testStatementPeriod()
    //{
    //    $enabled = false;
    //    $descrption = 'a 120 day statement';
    //    $name ="a name";
    //    $period = new StatementPeriod();
    //    $units = 30;
    //    $id =1;
    //    
    //    # test default value
    //    $this->assertTrue($period->getEnabled());
    //    
    //    # test enabled property
    //    $period->setEnabled(false);
    //    $this->assertFalse($period->getEnabled());
    //    
    //    # test description
    //    $period->setDescription($descrption);
    //    $this->assertEquals($descrption,$period->getDescription());
    //    
    //    # test the name
    //    $period->setName($name);
    //    $this->assertEquals($name,$period->getName());
    //    
    //    # test the period
    //    $period->setUnits($units);
    //    $this->assertEquals($units,$period->getUnits());
    //    
    //    # test database id
    //    $period->setStatementPeriodID($id);
    //    $this->assertEquals($id,$period->getStatementPeriodID());
    //}
    //
    
    ///**
    // * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
    // * @expectedExceptionMessage Statement Period enabled flag must be a boolean
    // * 
    //*/ 
    //public function testStatementPeriodErrorEnabledNotBoolean()
    //{
    //    $period = new StatementPeriod();
    //    
    //    $period->setEnabled('');
    //}
    //
    // /**
    // * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
    // * @expectedExceptionMessage Statement Period description must be a string
    // * 
    //*/ 
    //public function testStatementPeriodErrorDescriptionNotString()
    //{
    //    $period = new StatementPeriod();
    //    $period->setDescription(1);
    //    
    //}
    //
    //
    //
    ///**
    // * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
    // * @expectedExceptionMessage Statement Period description must be between 1 and 255 characters
    // * 
    //*/ 
    //public function testStatementPeriodErrorDescriptionEmpty()
    //{
    //    $period = new StatementPeriod();
    //    $period->setDescription('');
    //}
    //
    // /**
    // * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
    // * @expectedExceptionMessage Statement Period description must be between 1 and 255 characters
    // * 
    //*/ 
    //public function testStatementPeriodErrorDescriptionTooBig()
    //{
    //    $period = new StatementPeriod();
    //    $period->setDescription(str_repeat('a',256));
    //}
    //
    //
    // /**
    // * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
    // * @expectedExceptionMessage Statement Period name must be a string
    // * 
    //*/ 
    //public function testStatementPeriodErrorNameNotString()
    //{
    //    $period = new StatementPeriod();
    //    $period->setName(1);
    //    
    //}
    //
    //
    //
    ///**
    // * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
    // * @expectedExceptionMessage Statement Period name must be between 1 and 50 characters
    // * 
    //*/ 
    //public function testStatementPeriodErrorNameEmpty()
    //{
    //    $period = new StatementPeriod();
    //    $period->setName('');
    //}
    //
    ///**
    // * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
    // * @expectedExceptionMessage Statement Period name must be between 1 and 50 characters
    // * 
    //*/ 
    //public function testStatementPeriodErrorNameTooBig()
    //{
    //    $period = new StatementPeriod();
    //    $period->setName(str_repeat('a',51));
    //}
    //
    //
    ///**
    // * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
    // * @expectedExceptionMessage Statement Period units must be an integer
    // * 
    //*/ 
    //public function testStatementPeriodErrorUnitsNotInteger()
    //{
    //    $period = new StatementPeriod();
    //    $period->setUnits('');
    //    
    //}
    //
    ///**
    // * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
    // * @expectedExceptionMessage Statement Period units must be an integer > 0
    // * 
    //*/ 
    //public function testStatementPeriodErrorUnitsBadRange()
    //{
    //    $period = new StatementPeriod();
    //    $period->setUnits(0);
    //    
    //}
    //
    //
    ///**
    // * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
    // * @expectedExceptionMessage Statement Period id must be an integer
    // * 
    //*/ 
    //public function testStatementPeriodErrorIDNotInteger()
    //{
    //    $period = new StatementPeriod();
    //    $period->setStatementPeriodID('');
    //    
    //}
    //
    ///**
    // * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
    // * @expectedExceptionMessage Statement Period id must be an integer > 0
    // * 
    //*/ 
    //public function testStatementPeriodErrorIDBadRange()
    //{
    //    $period = new StatementPeriod();
    //    $period->setStatementPeriodID(0);
    //}
    //
    //
    //public function testOrganisationUnit()
    //{
    //    $id = 1;
    //    $name = 'a valid name';
    //    $validFrom = new \DateTime();
    //    $validTo = clone $validFrom;
    //    $validTo->modify('+ 1 week');
    //    
    //    $unit = new OrganisationUnit();
    //    
    //    
    //    # test the id
    //    $unit->setOrganisationUnitID($id);
    //    $this->assertEquals($id,$unit->getOrganisationUnitID());
    //    
    //    # test the name
    //    $unit->setOrganisationName($name);
    //    $this->assertEquals($name, $unit->getOrganisationName());
    //    
    //    
    //    # test the valid from
    //    $unit->setValidFrom($validFrom);
    //    $this->assertEquals($validFrom, $unit->getValidFrom());
    //    
    //    # test the valid to
    //    $unit->setValidTo($validTo);
    //    $this->assertEquals($validTo, $unit->getValidTo());
    //    
    //    
    //    
    //}
    //
    ///**
    // * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
    // * @expectedExceptionMessage Organisation Unit ID must be an integer
    // * 
    //*/ 
    //public function testOrganisationUnitErrorIDNotInteger()
    //{
    //    $unit = new OrganisationUnit();
    //    $unit->setOrganisationUnitID('a string');
    //    
    //}
    //
    ///**
    // * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
    // * @expectedExceptionMessage Organisation Unit ID must be an integer > 0
    // * 
    //*/ 
    //public function testOrganisationUnitErrorIDLessZero()
    //{
    //    $unit = new OrganisationUnit();
    //    $unit->setOrganisationUnitID(0);
    //    
    //}
    //
    //public function testOrganisationUnitErrorNameNotString()
    //{
    //    
    //}
    //
    //
    //public function testOrganisationUnitErrorNameOutofRange()
    //{
    //    
    //    
    //}
    
    
    
    
  
    
}
/* End of Class */
