<?php
namespace IComeFromTheNet\Ledger\Builder;

use DateTime;
use BlueM\Tree\Node;
use IComeFromTheNet\Ledger\Entity\AccountGroup;
use IComeFromTheNet\Ledger\Builder\NodeBuilderInterface;
use IComeFromTheNet\Ledger\Builder\AccountDefinition;
use IComeFromTheNet\Ledger\Builder\AccountGroupNode;


/**
  *  Helps build Account Groups
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class RootGroupBuilder implements NodeBuilderInterface
{
    
    protected $now;
    
    protected $rootNode;
    
    protected $creditNode;
    
    protected $debitNode;
    
    /**
     *  Class Constructor
     *
     *  @access public
     *  @return void
     *
    */
    public function __construct(AccountGroupNode $root,DateTime $now)
    {
        $this->now        = $now;
        $this->rootNode   = $root;
    }
    
    /**
     *  Return a GroupBuilder 
     *
     *  @access public
     *  @return DebitGroupBuilder
     *
    */
    public function debit()
    {
        return new DebitGroupBuilder($this,$this->now);
    }
    
     /**
     *  Return a GroupBuilder 
     *
     *  @access public
     *  @return CreditGroupBuilder
     *
    */
    public function credit()
    {
        return new CreditGroupBuilder($this,$this->now);
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
        return $this->rootNode;
    }
   
    /**
     *  Return the parent account node tree
     *
     *  @access public
     *  @return  AccountGroupNode
     *
    */
    public function end()
    {
        $closed = new DateTime();
        $closed->setDate(3000,1,1);
        $closed->setTime(0,0,0);
        
        # create root AccountGroup 
        $rootGroup = new AccountGroup();
        $rootGroup->setName('Root Group');
        $rootGroup->setDescription('Top level group');
        $rootGroup->setDateAdded($this->now);
        $rootGroup->setDateRemoved($closed);
        
        # add the group to the node
        $this->rootNode->setInternal($rootGroup);
        
        return $this->rootNode;
    }
    
}
/* End of Class */
