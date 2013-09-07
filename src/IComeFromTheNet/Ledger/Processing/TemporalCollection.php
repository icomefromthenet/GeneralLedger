<?php
namespace IComeFromTheNet\Ledger\Processing;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use IComeFromTheNet\Ledger\Processing\RuleChainInterface;

/**
  *  Collection of RuleChains indexed by date. 
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class TemporalCollection extends ArrayCollection
{
    
    
    public function registerChain($name,RuleChainInterface $chain)
    {
        
        
    }
    
    public function sliceByDate($applyFrom)
    {
        
    }
    
    
}
/* End of Class */
