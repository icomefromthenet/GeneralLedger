<?php
namespace IComeFromTheNet\Ledger\Processing;

use IComeFromTheNet\Ledger\Processing\RuleChainInterface;

/**
  *  Allows RuleChains to be named and allows abstracts the
  *  temporal nature of RuleChains/PostingRules, Can have a
  *  set of rules that affect the past, a set rules for current
  *  and a set of rules for future. 
  *  
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
interface NamedChainInterface
{
    
    
    
    /**
     *  Registers a RuleChain under this named rule
     *
     *  @access public
     *  @return void
     *  @param RuleChainInterface $ruleChain 
     *
    */
    public function registerChain(RuleChainInterface $ruleChain);
 
    /**
     *  The Name of this rule change
     *
     *  @access public
     *  @return string
     *
    */
    public function getName();

    
}
/* End of Interface */