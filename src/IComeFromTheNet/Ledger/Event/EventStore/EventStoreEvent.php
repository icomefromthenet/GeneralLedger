<?php
namespace IComeFromTheNet\Ledger\Event\EventStore;

use Symfony\Component\EventDispatcher\Event;
use IComeFromTheNet\Ledger\Entity\AccountingEvent;

/**
  *  Event object for the AccountEventsStore
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class EventStoreEvent extends Event
{
    /*
     * @var IComeFromTheNet\Ledger\Entity\AccountingEvent
     */
    protected $acEvent;
    
     /*
     * @var string an error message
     */
    protected $errorMsg;
   
    public function __construct(AccountingEvent $event,$errorMsg = '')
    {
        $this->acEvent  = $event;
        $this->errorMsg = $errorMsg;
    }
    
    
    /**
     *  Return the Unit of Work
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\Entity\AccountingEvent
     *
    */
    public function getAccountingEvent()
    {
        return $this->acEvent;
    }
    
    /**
     *  Return an error message
     *
     *  @access public
     *  @return string
     *
    */
    public function getErrorMessage()
    {
        return $this->errorMsg;
    }
}
/* End of Class */



