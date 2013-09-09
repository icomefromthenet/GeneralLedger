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
    public function setIntrenal(AccountGroup $accountGroup)
    {
        $this->internal = $accountGroup;
    }
    
    /**
     *  Has this node been visited, default to false
     *
     *  @access public
     *  @return boolean true if visted
     *
    */
    public function getVisited()
    {
        return $this->visited;
    }
    
    /**
     *  Sets if this node has been visited in search
     *
     *  @access public
     *  @return void
     *
    */
    public function setVisited($vis)
    {
        $this->visited = (boolean) $vis;
    }
    
    /**
     *  Reset visited status
     *
     *  @access public
     *  @return void
     *
    */
    public function resetVisited()
    {
        $this->setVisited(false);
        
        foreach($this->children as $child) {
            $this->children->resetVisited();
        }
        
    }
    
    /**
     *  Search for a group by name and will return
     *  after first match
     *
     *  @access public
     *  @return AccountGroupNode| null if none found 
     *
    */
    public function searchForGroupByName($name)
    {
        $queue = array();
        array_unshift($queue, $this);
        $this->setVisited(true);
     
        while (sizeof($queue)) {
            $vertex = array_pop($queue);
            # do we have a match
            if($vertex->getInternal()->getGroupName() === $name) {
               $node = $this;
               break;
            }
            
            foreach ($vertex->getChildren() as $child) {
                # Only check children, which were not visited yet
                if (!$child->getVisited()) {
                    # mark vertex as visited
                    $vertex->setVisited(true);
                    array_unshift($queue, $child);    
                }
            }
        }    
        
        # reset visited for next search
        $this->resetVisited();
        
        return $node;
    }
    
}
/* End of Class */
