<?php
namespace IComeFromTheNet\Ledger\Event\Ledger;

/**
  *  List of events that occur when processing accounting events
  *  
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
final class LedgerEvents
{
    /**
     * The accounting.event.committed event is thrown each time an accounting event is committed
     *
     * The event listener receives an
     * Acme\StoreBundle\Event\FilterOrderEvent instance.
     *
     * @var string
     */
    const EVENT_COMMITTED = 'accounting.event.committed';
    
 
    
    
}