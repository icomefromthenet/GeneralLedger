<?php
namespace IComeFromTheNet\Ledger\Processing;

use IComeFromTheNet\Ledger\Processing\PostingRuleInterface;

/**
  *  Behaviour of a chain made of posting rules.
  *  One created and configured the chain is immutable
  *
  *  There are two processing modes.
  *  1. StopOnFirstException - catch exception and try next rule
  *  2. ProcessEntireChain - prevent stopping on first rule to handle
  *
  *  A chain as an applyFrom Date, if context existed before this date,
  *  the chain can be ignored.
  *
  *  Normally RuleChains are loaded into a TemporalCollection.
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
interface RuleChainInterface 
{
    
    
    /**
     *  Return the the processing mode, true will have all
     *  rule applied to chain , false stop on first handler to process
     *
     *  @access public
     *  @return boolean
     *
    */
    public function getProcessingMode();
    
    
    /**
     *  Return the error mode, true will stop execution on
     *  first rule to throw a LedgerException, false will
     *  cause execution to continue
     *
     *  @access public
     *  @return boolean 
     *
    */
    public function getErrorMode();    
    
    
    /**
     *  Register a rule inside the chain, order of execution is FIFO.
     *
     *  @access public
     *  @return void
     *  @param PostingRuleInterface $rule a posting rule to register
     *
    */
    public function registerRule(PostingRuleInterface $rule);
    
   
    /**
     *  Return the date that this chain should apply from
     *
     *  @access public
     *  @return DateTime date chain should apply from
     *
    */
    public function getApplyDate();
    
}
/* End of Interface */