<?php
namespace IComeFromTheNet\Ledger\Builder;

use DateTime;
use IComeFromTheNet\Ledger\Entity\Account;
use BlueM\Tree\Node;

/**
  *  Definition To Build Accounts
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class AccountDefinition implements NodeBuilderInterface
{
    
    protected $accountName;
    protected $accountNumber;
    protected $now;
    
    protected $accountTreeNode;
    protected $parentNode;
    
    
    public function __construct(NodeBuilderInterface $parent, DateTime $now)
    {
        $this->parentNode = $parent;
        $this->now        = $now;
        
    }
    
    /**
     *  Set the name of the account
     *  
     *  @access public
     *  @return AccountDefinition
     *
    */
    public function accountName($name)
    {
        $this->accountName = $name;
        
        return $this;
    }
    
    /**
     *  Set the account number
     *  
     *  @access public
     *  @return AccountDefinition
     *
    */
    public function accountNumber($number)
    {
        $this->accountNumber = $number;
        
        return $this;
    }
    
    
    
    /**
     *  Fetch the instanced TreeNode
     *
     *  @access public
     *  @return AccountNode
     *
    */
    public function getNode()
    {
        if($this->accountTreeNode === null) {
            # create new tree node and attach to parent
            $this->accountTreeNode = new AccountNode(array('id' => uniqid()));
        }
        
        return $this->accountTreeNode;
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
        $account = new Account();
        $closed = new DateTime();
        $closed->setDate(3000,1,1);
        $closed->setTime(0,0,0);
        
        # group id will be set later when group has
        # been saved
        $account->setAccountName($this->accountName);
        $account->setAccountNumber($this->accountNumber);
        $account->setDateOpened($this->now);
        $account->setDateClosed($closed);
        
        # attach the new entity to node to the tree node
        $this->getNode()->setInternal($account);
        
        # add account to an account group
        $parentTreeNode = $this->parentNode->getNode()->addChild($this->accountTreeNode);
        
        return $this->parentNode;
    }
}
/* End of Class */

