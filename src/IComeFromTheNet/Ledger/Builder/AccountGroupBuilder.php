<?php
namespace IComeFromTheNet\Ledger\Builder;

use DateTime;

/**
  *  Helps build Account Groups
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class AccountGroupBuilder implements NodeBuilderInterface
{
    
    protected $now;
    
    protected $def;
    
    /**
     *  Class Constructor
     *
     *  @access public
     *  @return void
     *
    */
    public function __construct(DateTime $now)
    {
        $this->now = $now;
    }
    
    /**
     *  Return a root node builder
     *
     *  @access public
     *  @return AccountGroupDefinition
     *
    */
    public function root()
    {
        $this->def = new AccountGroupDefinition($this,$this->now);
        
        return $this->def;
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
        return null;        
    }
   
    /**
     *  Return the tree root node
     *
     *  @access public
     *  @return AccountGroupNode
     *
    */
    public function end()
    {
        return  $this->def->getNode();       
    }
    
}
/* End of Class */
