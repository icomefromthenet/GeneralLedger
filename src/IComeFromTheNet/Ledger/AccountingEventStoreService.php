<?php
namespace IComeFromTheNet\Ledger;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use IComeFromTheNet\Ledger\Entity\AccountingEvent;
use IComeFromTheNet\Ledger\DB\AccountingEventGateway;
use DBALGateway\Exception as DBALException;

/**
  *  Ledger Service API
  *
  *  Receive/Reverse and Query AccountingEvents
  *  Once an event is received it can not be removed, use a reversal to cancel out event
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class AccountingEventStoreService
{
    /*
     * @var IComeFromTheNet\Ledger\DB\AccountingEventGateway
     */
    protected $eventGateway;
    
    /*
     * @var Symfony\Component\EventDispatcher\EventDispatcherInterface e
     */
    protected $eventDispatcher;
    
    
    /**
     *  Class Constructor
     *
     *  @access public
     *  @return void
     *
    */        
    public function __construct(AccountingEventGateway $eventGateway,EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->eventGateway    = $eventGateway;
        
    }
    
    /**
     *  Receive an accounting Event
     *
     *  @access public
     *  @return void
     *
    */
    public function receive(AccountingEvent $event)
    {
        # fire the event received
        
        # start transaction
        
        try {
            $this->process($event);
            
        } catch(DBALException $e) {
            # end transaction
            
            # throw exception
        }
        
        # fire committed event.
        
        # commit the event
       
    }
    
    /**
     *  Reverse and accounting event with another
     *
     *  @access public
     *  @return void
     *
    */
    public function reverse(AccountingEvent $orgEvent,AccountingEvent $reversalEvent)
    {
        # fire reversal event rec
        
        # clone org event details
        
                
        if($this->process($event) === true) {
              # fire committed event.    
        }
        
        # fire reversl event committed
    }
    
    /**
     *  Will process an adjustment requires org and the reversal first
     *  Exists as hint to other developers that to complete adjustment is three step process
     *  1. Fetch Orginal and verify exists
     *  2. Reverse the org event with todays date
     *  3. Adjust event with new value on todays date
     *
     *  @access public
     *  @return void
     *
    */
    public function adjust(AccountingEvent $orgEvent,AccountingEvent $reversalEvent,AccountingEvent $adjustEvent)
    {
        
    }
    
    /**
     *  Find a query given an id 
     *
     *  @access public
     *  @return void
     *
    */
    public function findOne($id)
    {
       $obj = null;
       
       $query = new $this->eventGateway->newQueryBuilder();
       
       return $obj;
    }
    
    /**
     *  Supplies a query builder 
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\Query\AccountingEventQuery
     *
    */
    public function findMany()
    {
        return new $this->eventGateway->newQueryBuilder();
    }
}
/* End of Class */