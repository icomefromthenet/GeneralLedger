<?php
namespace IComeFromTheNet\Ledger\Test;

use DateTime;
use IComeFromTheNet\Ledger\Entity\AccountGroup;
use IComeFromTheNet\Ledger\Entity\Account;
use IComeFromTheNet\Ledger\DB\AccountGroupBuilder;
use IComeFromTheNet\Ledger\DB\AccountBuilder;

/**
  *  Unit test of the Entity Builders
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class EntityBuilderTest extends \PHPUnit_Framework_TestCase
{
    
    public function testAccountGroupBuilderBuild()
    {
        $name        = 'an entity group';
        $description ='A description of entity group';
        $dateRemoved = new DateTime();
        $dateRemoved->setDate(3000,1,1);
        $dateAdded   = new DateTime();
        $groupID     = 100;
        $parentGroup = 5;
        
        $builder = new AccountGroupBuilder();
        
        $columns = array(
                'group_name'         => $name,
                'group_description'  => $description,
                'group_date_added'   => $dateAdded,
                'group_date_removed' => $dateRemoved,
                'group_id'           => $groupID,
                'parent_group_id'    => $parentGroup
        );
        
        $entity = $builder->build($columns);
        
        $this->assertEquals($name,$entity->getName());
        $this->assertEquals($description,$entity->getDescription());
        $this->assertEquals($dateAdded,$entity->getDateAdded());
        $this->assertEquals($dateRemoved,$entity->getDateRemoved());
        $this->assertEquals($groupID,$entity->getGroupID());
        $this->assertEquals($parentGroup,$entity->getParentGroupID());
        
    }
    
    public function testAccountGroupBuilderDemolish()
    {
        $name        = 'an entity group';
        $description ='A description of entity group';
        $dateRemoved = new DateTime();
        $dateRemoved->setDate(3000,1,1);
        $dateAdded   = new DateTime();
        $groupID     = 100;
        $parentGroup = 5;
        
        $builder = new AccountGroupBuilder();
        $entity  = new AccountGroup();
        
        $entity->setName($name);
        $entity->setDescription($description);
        $entity->setDateAdded($dateAdded);
        $entity->setDateRemoved($dateRemoved);
        $entity->setGroupID($groupID);
        $entity->setParentGroupID($parentGroup);
        
        $columns = array(
                'group_name'         => $name,
                'group_description'  => $description,
                'group_date_added'   => $dateAdded,
                'group_date_removed' => $dateRemoved,
                'group_id'           => $groupID,
                'parent_group_id'    => $parentGroup
        );
        
        $this->assertEquals($builder->demolish($entity),$columns);
        
    }
    
    
    public function testAccountBuilderBuild()
    {
        $accountNumber = 1;
        $accountName = 'an account';
        $dateOpened = new DateTime();
        $dateClosed = new DateTime();
        $dateClosed->setDate(3000,1,1);
        $groupId  = 1;
        
        $builder = new AccountBuilder();
        
        $column = array(
                'account_number'      => $accountNumber,
                'account_name'        => $accountName,
                'account_date_opened' => $dateOpened,
                'account_date_closed' => $dateClosed,
                'account_group_id'    => $groupId
        );
        
        $entity = $builder->build($column);
        
        $this->assertEquals($accountNumber,$entity->getAccountNumber());
        $this->assertEquals($accountName,$entity->getAccountName());
        $this->assertEquals($dateOpened,$entity->getDateOpened());
        $this->assertEquals($dateClosed,$entity->getDateClosed());
        $this->assertEquals($groupId, $entity->getGroupId());
        
    }
    
    
    public function testAccountBuilderDemolish()
    {
        $accountNumber = 1;
        $accountName = 'an account';
        $dateOpened = new DateTime();
        $dateClosed = new DateTime();
        $dateClosed->setDate(3000,1,1);
        $groupId  = 1;
        
        $builder = new AccountBuilder();
        $entity = new Account();
        
         $column = array(
                'account_number'      => $accountNumber,
                'account_name'        => $accountName,
                'account_date_opened' => $dateOpened,
                'account_date_closed' => $dateClosed,
                'account_group_id'    => $groupId
        );
         
        $entity->setAccountNumber($accountNumber);
        $entity->setAccountName($accountName);
        $entity->setDateOpened($dateOpened);
        $entity->setDateClosed($dateClosed);
        $entity->setGroupId($groupId);
        
        
        $this->assertEquals($column,$builder->demolish($entity));
    }
    
}