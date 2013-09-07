<?php
namespace IComeFromTheNet\Ledger\Event\EventStore;

/**
  *  List of events that occur when storing Accounting Events (not processing)
  *  
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
final class EventStoreEvents
{
    /**
     * The accounting.eventstore.received event is thrown each time an event has been receved.
     *
     * @var string
     */
    const EVENT_RECEIVED = 'accounting.eventstore.received';
    
    
    /**
     * The accounting.eventstore.saved event is thrown when event has been saved to store
     *
     * @var string
     */
    const EVENT_SAVED = 'accounting.eventstore.saved';
    
    
    /**
     * The accounting.eventstore.error event is thrown when envent could not saved to the store
     *
     * @var string
     */
    const EVENT_ERROR = 'accounting.eventstore.error';
    
}
/* End of Class */