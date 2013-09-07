<?php
namespace IComeFromTheNet\Ledger\Event\Ledger;

/**
  *  List of events that occur when storing Ledger Transaction
  *  
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
final class LedgerTransactionEvents
{
    /**
     * The accounting.ledger.received event is thrown each time an event has been receved.
     *
     * @var string
     */
    const EVENT_RECEIVED = 'accounting.ledger.received';
    
    
    /**
     * The accounting.ledger.saved event is thrown when event has been saved to store
     *
     * @var string
     */
    const EVENT_SAVED = 'accounting.ledger.saved';
    
    
    /**
     * The accounting.ledger.error event is thrown when envent could not saved to the store
     *
     * @var string
     */
    const EVENT_ERROR = 'accounting.ledger.error';
    
}
/* End of Class */