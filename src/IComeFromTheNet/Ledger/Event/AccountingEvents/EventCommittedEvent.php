<?php
namespace IComeFromTheNet\Ledger\Event\AccountingEvents;

use Symfony\Component\EventDispatcher\Event;
use IComeFromTheNet\Ledger\Entity\AccountingEvent;

/**
  *  Event occurs when Account event has been committed to the store
  *  The event may or may not be processed when this is fired
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class EventCommittedEvent extends Event
{
    /*
     * @var IComeFromTheNet\Ledger\Entity\AccountingEvent the event saved to the store
     */
    protected $accountingEvent;
    
   
    public function __construct(AccountingEvent $entity)
    {
        $this->accountingEvent = $event;
    }
    
    
    /**
     *  Ehe Accounting Event committed to the store
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\Entity\AccountingEvent
     *
    */
    public function getAccountingEvent()
    {
        return $this->accountingEvent;
    }
}
/* End of Class */
