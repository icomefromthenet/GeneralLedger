<?php
namespace IComeFromTheNet\Ledger\Processing;

use IComeFromTheNet\Ledger\Exception\LedgerException;
use Doctrine\Common\Collections\ArrayCollection;

/**
  *  Collection of LedgerExceptions thrown by PostingRules during execution of
  *  a RuleChain.
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class ErrorCollection extends ArrayCollection
{
    
    /**
     *  Registers an Exception
     *
     *  alias ArrayCollection::set()
     *
     *  @access public
     *  @return void
     *  @param string $postingRuleName the name of the rule made the exception
     *  @param LedgerException the exception raised
     *
    */
    public function registerException($postingRuleName,LedgerException $e)
    {
        return $this->set($postingRuleName,$e);            
    }
    
    /**
     *  Return an exception using posting rule name
     *
     *  alias ArrayCollection::get()
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\Exception\LedgerException
     *  @param string $postingRuleName the name of the rule
     *
    */    
    public function getExceptionForRule($postingRuleName)
    {
        $this->get($postingRuleName);
    }
    
    
}
/* End of Class */
