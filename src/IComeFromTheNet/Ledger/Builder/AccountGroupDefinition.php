<?php
namespace IComeFromTheNet\Ledger\Builder;

use DateTime;
use IComeFromTheNet\Ledger\Entity\AccountGroup;
use BlueM\Tree\Node;

/**
  *  Definition To Build AccountGroups 
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class AccountGroupDefinition implements NodeBuilderInterface
{
    
    protected $name;
    protected $description;
    protected $now;
    
    protected $accountGroupTreeNode;
    protected $parentNode;
    
    
    public function __construct(NodeBuilderInterface $parent, DateTime $now)
    {
        $this->parentNode = $parent;
        $this->now        = $now;
        
    }
    
    /**
     *  Set the name of the accountGroup
     *
     *  @access public
     *  @return AccountGroupDefinition
     *
    */
    public function name($name)
    {
        $this->name = $name;
        
        return $this;
    }
    
    /**
     *  Sets the group description
     *
     *  @access public
     *  @return AccountGroupDefinition
     *
    */
    public function description($description)
    {
        $this->description = $description;
    }
    
    
    /**
     *  Return a new Definition
     *
     *  @access public
     *  @return AccountGroupDefinition
     *
    */
    public function children()
    {
        return new self($this,$this->now);
    }
    
     /**
     *  Fetch the instanced TreeNode
     *
     *  @access public
     *  @return AccountGroupNode
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
     *  Will do node construction and assignment passback parent.
     *
     *  @access public
     *  @return NodeBuilderInterface
     *
    */
    public function end()
    {
        $group = new AccountGroup();
        $group->setGroupDateAdded($this->now);
        $group->setGroupDescription($this->description);
        $group->setGroupName($this->name);
        
        # attach the new entity to node to the tree node
        $this->getNode()->setIntrenal($group);
        
        # add new tree node to the parent node
        # if null returned by parent this def must contain root node
        $parentTreeNode =$this->parentNode->getNode();
        if($parentTreeNode !== null) {
            $parentTreeNode->addChild($this->accountGroupTreeNode);    
        }
        
        return $this->parentNode;
    }
}
/* End of Class */

