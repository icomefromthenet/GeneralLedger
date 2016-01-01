<?php
namespace IComeFromTheNet\Ledger\Builder;

use BlueM\Tree\Node;
use IComeFromTheNet\Ledger\Entity\AccountGroup;

/**
  *  Node in the AccountTree
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class AccountGroupNode extends Node implements NodeInterface
{
    /*
     * @var IComeFromTheNet\Ledger\Entity\AccountGroup
     */
    protected $internal;
    
    protected $visited = false;
    
    /**
     *  Fetch the AccountGroup assigned     
     *
     *  @access public
     *  @return AccountGroup if one is assigned
     *
    */
    public function getInternal()
    {
        return $this->internal;
    }
    
    /**
     *  Set the account group
     *
     *  @access public
     *  @return void
     *  @param AccountGroup $accountGroup
     *
    */
    public function setInternal(AccountGroup $accountGroup)
    {
        $this->internal = $accountGroup;
    }
    
    
    /**
     *  Assign a group ID to child nodes
     *
     *  @access public
     *  @return void
     *  @param integer $id parent group id
    */
    public function assignGroupID($id)
    {
        $children = $this->getChildren();
                
        //foreach($children as $child) {
        //    
        //    $child->getInternal()->setParentGroupID($id);
        //}
        
    }
    
    /**
     *  Fetch the assigned group ID
     *
     *  @access public
     *  @return integer the group id assigned
    */
    public function getGroupID()
    {
        return $this->getInternal()->getGroupID();
    }
    
}
/* End of Class */
