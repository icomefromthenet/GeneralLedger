<?php
namespace IComeFromTheNet\Ledger\Event\Service;

/**
  *  List of events that occur during Ledger Load up by the service provider
  *  
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
final class LedgerServiceEvents
{
    /**
     * The accounting.ledger.servce.started event is raised each time a ledger is booted
     *
     * @var string
     */
    const EVENT_LEDGER_STARTED = 'accounting.ledger.servce.started';
    
    
    /**
     * The accounting.ledger.servce.rules.resolved event is raised each time a ledger sucessfuly
     * loads the rules for occured date.
     *
     * @var string
     */
    const EVENT_LEDGER_RULES_RESOLVED = 'accounting.ledger.servce.rules.resolved';
    
    
    
    
}
/* End of Class */