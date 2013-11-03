<?php
namespace IComeFromTheNet\Ledger\Builder;

use DateTime;
use IComeFromTheNet\Ledger\Builder\NodeBuilderInterface;
use IComeFromTheNet\Ledger\Builder\AccountDefinition;
use IComeFromTheNet\Ledger\Builder\AccountGroupNode;
use IComeFromTheNet\Ledger\Entity\AccountGroup;

/**
  *  Helps build Account Groups
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class AccountGroupBuilder implements NodeBuilderInterface
{
    
    protected $now;
    
    protected $parentNode;
    
    protected $accountGroupTreeNode;
    
    protected $groupName;
    
    protected $groupDescription;
    
    /**
     *  Class Constructor
     *
     *  @access public
     *  @return void
     *
    */
    public function __construct(NodeBuilderInterface $parent,DateTime $now)
    {
        $this->now        = $now;
        $this->parentNode = $parent;
    }
    
    
     /**
     *  Return an AccountGroup Builder
     *
     *  @access public
     *  @return AccountGroupBuilder
     *  @param string $name the group anme
     *
    */
    public function groupName($name)
    {
        $this->groupName = $name;
        
        return $this;
    }
    
     /**
     *  Return an AccountGroup Builder
     *
     *  @access public
     *  @return AccountGroupBuilder
     *  @param string $description the group description
     *
    */
    public function groupDescription($description)
    {
        $this->groupDescription = $description;
        
        return $this;
    }
    
    
    /**
     *  Return an AccountGroup Builder
     *
     *  @access public
     *  @return AccountGroupBuilders
     *
    */
    public function addGroup()
    {
        return new self($this,$this->now);
    }
    
    
    /**
     *  Return an AccountDefinition builder
     *
     *  @access public
     *  @return void AccountDefinition
     *
    */
    public function addAccount()
    {
        return new AccountDefinition($this,$this->now);
    }
    
    
    /**
     *  Return empty node
     *
     *  @access public
     *  @return void
     *
    */
    public function getNode()
    {
        if($this->accountGroupTreeNode === null) {
            # create new tree node and attach to parent
            $this->accountGroupTreeNode = new AccountGroupNode(array('id' => uniqid()));
        }
        
        return $this->accountGroupTreeNode;
    }
   
    /**
     *  Return the parent NodeBuilder
     *
     *  @access public
     *  @return  NodeBuilderInterface
     *
    */
    public function end()
    {
        $group = new AccountGroup();
        $closed = new DateTime();
        $closed->setDate(3000,1,1);
        $closed->setTime(0,0,0);
        
        $group->setGroupName($this->groupName);
        $group->setGroupDescription($this->groupDescription);
        $group->setDateAdded($this->now);
        $group->setDateRemoved($closed);
        
        # attach the new accountGroup entity to the tree node
        $this->getNode()->setInternal($group);
        
        # add new tree node to the parent node
        $this->parentNode->getNode()->addChild($this->getNode());
        
        return  $this->parentNode;     
    }
    
}
/* End of Class */
