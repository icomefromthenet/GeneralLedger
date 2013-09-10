<?php
namespace IComeFromTheNet\Ledger\Test;

use DateTime;
use DateInterval;
use IComeFromTheNet\Ledger\Entity\AccountGroup;
use IComeFromTheNet\Ledger\Entity\Account;
use IComeFromTheNet\Ledger\Builder\AccountNode;
use IComeFromTheNet\Ledger\Builder\AccountGroupNode;
use IComeFromTheNet\Ledger\Builder\AccountDefinition;
use IComeFromTheNet\Ledger\Builder\AccountGroupBuilder;
use IComeFromTheNet\Ledger\Builder\DebitGroupBuilder;
use IComeFromTheNet\Ledger\Builder\CreditGroupBuilder;
use IComeFromTheNet\Ledger\Builder\RootGroupBuilder;


/**
  *  Unit test of the Builders
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class BuilderTest extends \PHPUnit_Framework_TestCase
{
   public function testGroupNodeProperties()
   {
        $internal = new AccountGroup();
        $node    = new AccountGroupNode(array());
        
        $node->setInternal($internal);
        
        $this->assertEquals($internal,$node->getInternal());
   }
   
   public function testAccountNodeProperties()
   {
        $internal = new Account();
        $node     = new AccountNode(array());
        
        $node->setInternal($internal);
        
        $this->assertEquals($internal,$node->getInternal());
   }
   
   
   public function testAccountDefinitionConstructsCorrectly()
   {
        $parentNode = new \BlueM\Tree\Node(array('id'=>'1'));
        
        $parent = $this->getMock('IComeFromTheNet\Ledger\Builder\NodeBuilderInterface');
        
        #assert builder attaches treeNode to it's parent which create the chain link
        $parent->expects($this->once())
            ->method('getNode')
            ->will($this->returnValue($parentNode));
        
        $now    = new DateTime();
        $accountName ='my account';
        $accountNumber = 100;
        
        $definition = new AccountDefinition($parent,$now);
        
        # set name
        $definition->accountName($accountName);
        $definition->accountNumber($accountNumber);
        
        # assert end returns parent builder        
        $node = $definition->end();
        $this->assertEquals($parent,$node);
        
        
        # the internal account has been assigned correct details
        $this->assertEquals($accountName,$definition->getNode()->getInternal()->getAccountName());
        $this->assertEquals($accountNumber,$definition->getNode()->getInternal()->getAccountNumber());
        $this->assertEquals($now,$definition->getNode()->getInternal()->getDateOpened());
        $this->assertEquals('3000-01-01',$definition->getNode()->getInternal()->getDateClosed()->format('Y-m-d'));
    
   }
   
   
   
   public function testAccountGroupBuilder()
   {
        $now = new DateTime();
        $groupName = 'my group';
        $groupDescription = 'my group description';
        $parentNode = new \BlueM\Tree\Node(array('id'=>'1'));
        
        $parent = $this->getMock('IComeFromTheNet\Ledger\Builder\NodeBuilderInterface');
        
        #assert builder attaches treeNode to it's parent which create the chain link
        $parent->expects($this->once())
            ->method('getNode')
            ->will($this->returnValue($parentNode));
        
        $builder = new AccountGroupBuilder($parent,$now);
        
        $builder->groupDescription($groupDescription);
        $builder->groupName($groupName);
        
        # builder returns parent builder upon end()
        $this->assertEquals($parent,$builder->end());
        
        # assert internal entity setup correctly    
        $accountGroupEntity = $builder->getNode()->getInternal();
        $this->assertInstanceOf('IComeFromTheNet\Ledger\Entity\AccountGroup',$accountGroupEntity);
        $this->assertEquals($groupDescription,$accountGroupEntity->getDescription());
        $this->assertEquals($groupName,$accountGroupEntity->getName());
        $this->assertEquals($now,$accountGroupEntity->getDateAdded());
        $this->assertEquals('3000-01-01',$accountGroupEntity->getDateRemoved()->format('Y-m-d'));
        
        # assert addGroup and addAccount return definitions
        
        $this->assertInstanceOf('IComeFromTheNet\Ledger\Builder\AccountGroupBuilder',$builder->addGroup());
        $this->assertInstanceOf('IComeFromTheNet\Ledger\Builder\AccountDefinition',$builder->addAccount());
   }
   
   public function testDebitGroupBuilder()
   {
        $now = new DateTime();
        $groupName = 'Debit';
        $groupDescription = 'Debit Group';
        $parentNode = new \BlueM\Tree\Node(array('id'=>'1'));
        
        $parent = $this->getMock('IComeFromTheNet\Ledger\Builder\NodeBuilderInterface');
        
        #assert builder attaches treeNode to it's parent which create the chain link
        
        $parent->expects($this->once())
            ->method('getNode')
            ->will($this->returnValue($parentNode));
        
        $builder = new DebitGroupBuilder($parent,$now);
        
        # builder returns parent builder upon end()
        
        $this->assertEquals($parent,$builder->end());
        
        # assert internal entity setup correctly    
        
        $debitGroupEntity = $builder->getNode()->getInternal();
        $this->assertInstanceOf('IComeFromTheNet\Ledger\Entity\AccountGroup',$debitGroupEntity);
        $this->assertEquals($groupDescription,$debitGroupEntity->getDescription());
        $this->assertEquals($groupName,$debitGroupEntity->getName());
        $this->assertEquals($now,$debitGroupEntity->getDateAdded());
        $this->assertEquals('3000-01-01',$debitGroupEntity->getDateRemoved()->format('Y-m-d'));
        
        # assert addGroup and addAccount return definitions
        
        $this->assertInstanceOf('IComeFromTheNet\Ledger\Builder\AccountGroupBuilder',$builder->addGroup());
        $this->assertInstanceOf('IComeFromTheNet\Ledger\Builder\AccountDefinition',$builder->addAccount());
    
   }
   
   public function testCreditGroupBuilder()
   {
        $now = new DateTime();
        $groupName = 'Credit';
        $groupDescription = 'Credit Group';
        $parentNode = new \BlueM\Tree\Node(array('id'=>'1'));
        
        $parent = $this->getMock('IComeFromTheNet\Ledger\Builder\NodeBuilderInterface');
        
        #assert builder attaches treeNode to it's parent which create the chain link
        
        $parent->expects($this->once())
            ->method('getNode')
            ->will($this->returnValue($parentNode));
        
        $builder = new CreditGroupBuilder($parent,$now);
        
        # builder returns parent builder upon end()
        $this->assertEquals($parent,$builder->end());
        
        # assert internal entity setup correctly    
        $creditGroupEntity = $builder->getNode()->getInternal();
        $this->assertInstanceOf('IComeFromTheNet\Ledger\Entity\AccountGroup',$creditGroupEntity);
        $this->assertEquals($groupDescription,$creditGroupEntity->getDescription());
        $this->assertEquals($groupName,$creditGroupEntity->getName());
        $this->assertEquals($now,$creditGroupEntity->getDateAdded());
        $this->assertEquals('3000-01-01',$creditGroupEntity->getDateRemoved()->format('Y-m-d'));
        
        # assert addGroup and addAccount return definitions
        
        $this->assertInstanceOf('IComeFromTheNet\Ledger\Builder\AccountGroupBuilder',$builder->addGroup());
        $this->assertInstanceOf('IComeFromTheNet\Ledger\Builder\AccountDefinition',$builder->addAccount());
    
   }
   
   
   
   public function testRootBuilder()
   {
        $now        = new DateTime();
        $rootNode   = new AccountGroupNode(array('id'=>'1'));
        $builder    = new RootGroupBuilder($rootNode,$now);
        
        # return a credit builder
        $this->assertInstanceOf('IComeFromTheNet\Ledger\Builder\CreditGroupBuilder',$builder->credit());
        $this->assertInstanceOf('IComeFromTheNet\Ledger\Builder\DebitGroupBuilder',$builder->debit());
        
        # getNode() and end() return the root 
        $this->assertEquals($rootNode,$builder->getNode());
        $this->assertEquals($rootNode,$builder->end());
        
        #root group entity populated
        $rootGroupEntity = $builder->getNode()->getInternal();
        $this->assertEquals('Top level group',$rootGroupEntity->getDescription());
        $this->assertEquals('Root Group',$rootGroupEntity->getName());
        $this->assertEquals($now,$rootGroupEntity->getDateAdded());
        $this->assertEquals('3000-01-01',$rootGroupEntity->getDateRemoved()->format('Y-m-d'));
        
   }
   
   
   public function testCombinedExample()
   {
        $now        = new DateTime();
        $rootNode   = new AccountGroupNode(array('id'=>'1'));
        $builder    = new RootGroupBuilder($rootNode,$now);
    
    
        $tree = $builder
                ->debit()
                    ->addGroup()
                        ->groupName('gp2')
                        ->groupDescription('gp2 description')
                        ->addGroup()
                            ->groupName('gp3')
                            ->groupDescription('gp3 description')
                        ->end()
                    ->end()
                    ->addGroup()
                        ->groupName('gp1')
                        ->groupDescription('gp1 desc')
                    ->end()
                ->end()
                ->credit()
                    ->addGroup()
                        ->groupName('gp4')
                        ->groupDescription('gp5')
                    ->end()
                    ->addAccount()
                        ->accountName('account1')
                        ->accountNumber(100)
                    ->end()
                ->end()
            ->end();
                    
    
        $this->assertEquals(2,$tree->countChildren(),'Tree has debit and credit as first children');
        
   }
   
}