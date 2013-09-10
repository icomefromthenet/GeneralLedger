<?php
namespace IComeFromTheNet\Ledger\Builder;

use DateTime;
use IComeFromTheNet\Ledger\Builder\NodeBuilderInterface;
use IComeFromTheNet\Ledger\Builder\AccountDefinition;
use IComeFromTheNet\Ledger\Builder\AccountGroupNode;
use IComeFromTheNet\Ledger\Entity\AccountGroup;

/**
  *  Create a debit group node
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class DebitGroupBuilder implements NodeBuilderInterface
{
    
    protected $now;
    
    protected $parentNode;
    
    protected $groupTreeNode;
    
    
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
     *  @return AccountGroupDefinition
     *
    */
    public function addGroup()
    {
        return new AccountGroupBuilder($this,$this->now);
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
       if($this->groupTreeNode === null) {
            $this->groupTreeNode = new AccountGroupNode(array('id' => uniqid()));
            
            $closed = new DateTime();
            $closed->setDate(3000,1,1);
            $closed->setTime(0,0,0);
            
            $rootGroup = new AccountGroup();
            $rootGroup->setName('Debit');
            $rootGroup->setDescription('Debit Group');
            $rootGroup->setDateAdded($this->now);
            $rootGroup->setDateRemoved($closed);
            
            $this->groupTreeNode->setInternal($rootGroup);
        }
        
        return $this->groupTreeNode;
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
        # attach internal tree to parent
        $this->parentNode->getNode()->addChild($this->getNode());
        
        return  $this->parentNode;     
    }
    
    
}
/* End of Class */
