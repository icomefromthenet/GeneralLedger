<?php
namespace IComeFromTheNet\Ledger;

use IComeFromTheNet\Ledger\Entity\AccountingEvent;
use IComeFromTheNet\Ledger\Entity\LedgerTransaction;
use IComeFromTheNet\Ledger\Processing\ErrorCollection;
use IComeFromTheNet\Ledger\Processing\TransactionContext;

/**
  *  Posting Rules processing
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 
  */
class PostingRuleDispatcher
{
    
    protected $rulesCollection;
    
    
    
    public function __construct()
    {
        
    }
    
    
    public function process(AccountingEvent $accountingEvent,LedgerTransaction $ledgerTransaction)
    {
       $context = new TransactionContext($accountingEvent->getMemorandum(),$accountingEvent, $ledgerTransaction);
       $error   = new ErrorCollection();
       
       
       $occuredDate = clone $accountingEvent->getOccuredDate();
       
       # filter rules for event occure date
       
       
    }
    
    
    public function getRules()
    {
        
    }
    
}
/* End of File */
