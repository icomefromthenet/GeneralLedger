<?php
namespace IComeFromTheNet\Ledger\Processing;

use IComeFromTheNet\Ledger\Processing\TransactionContext;
use IComeFromTheNet\Ledger\Processing\ErrorCollection;

/**
  *  Behaviour for Posting Rule example of Strategy Pattern
  *  each rule is a flyweight must be constructed from factory. 
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
interface PostingRuleInterface
{
    /**
     *  Execute a rule to modify the context
     *  usually by adding acounts to ledger transaction
     *
     *  @access public
     *  @return void
     *  @param IComeFromTheNet\Ledger\Processing\TransactionContext $context
     *  @param IComeFromTheNet\Ledger\Processing\ErrorCollection $errors 
     *
    */
    public function execute(TransactionContext $context, ErrorCollection $errors);
    
    /**
     *  Determine if this rule should execute for this context.
     *  Run during execute method to exit early
     *
     *  @access public
     *  @return boolean true if rule applies
     *
    */
    public function isApplicable(TransactionContext $context);
}
/* End of Interface */