<?php
namespace IComeFromTheNet\Ledger\Test;

use DateTime;
use DateInterval;
use IComeFromTheNet\Ledger\Entity\AccountGroup;


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
        $group->setName($groupName);
        $group->setDescription($groupDescription);
        $group->setDateAdded($dateAdded);
        $group->setDateRemoved($dateRemoved);
        
        
        $this->assertEquals($groupID,$group->getGroupID());
        $this->assertEquals($groupName,$group->getName());
        $this->assertEquals($groupDescription,$group->getDescription());
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
     * @expectedExceptionMessage Group Name must be a string < 50 characters
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
     * @expectedExceptionMessage Group Name must be a string < 50 characters
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
     * @expectedExceptionMessage Group Description must be a string < 150 characters
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
     * @expectedExceptionMessage Group Description must be a string < 150 characters
     * 
    */ 
    public function testErrorAccountGroupDescriptionExceedsLimit()
    {
        $groupDescription = str_repeat('a',151);
        $group = new AccountGroup();
        $group->setDescription($groupDescription);
    }
    
    
    
    
}
/* End of Class */