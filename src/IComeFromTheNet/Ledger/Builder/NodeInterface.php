<?php
namespace IComeFromTheNet\Ledger\Builder;

/**
  *  Used by Tree Nodes (Result of the builders)
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
interface NodeInterface
{
    
    /**
     *  Fetch the AccountGroup assigned     
     *
     *  @access public
     *  @return mixed and entity object
     *
    */
    public function getInternal();
    
    
    /**
     *  Assign a group ID to child nodes
     *
     *  @access public
     *  @return void
     *  @param integer $id parent group id
    */
    public function assignGroupID($id);
    
    /**
     *  Fetch the assigned group ID
     *
     *  @access public
     *  @return integer the group id assigned
    */
    public function getGroupID();
    
    
}
/* End of Interface */