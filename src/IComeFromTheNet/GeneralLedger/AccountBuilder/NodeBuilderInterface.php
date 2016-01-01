<?php
namespace IComeFromTheNet\Ledger\Builder;

/**
  *  Collection of Builder/Defintion Nodes
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
interface NodeBuilderInterface
{
    
    
    
    /**
     *  Will do node construction and assignment passback parent.
     *
     *  @access public
     *  @return NodeBuilderInterface
     *
    */
    public function end();
    
    /**
     *  Fetch the instanced TreeNode
     *
     *  @access public
     *  @return BlueM\Tree\Node
     *
    */
    public function getNode();
    
}
/* End of Interface */
