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
class AccountGroupNode extends Node
{
    /*
     * @var IComeFromTheNet\Ledger\Entity\AccountGroup
     */
    protected $internal;
    
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
    public function setIntrenal(AccountGroup $accountGroup)
    {
        $this->internal = $accountGroup;
    }
    
    
}
/* End of Class */
