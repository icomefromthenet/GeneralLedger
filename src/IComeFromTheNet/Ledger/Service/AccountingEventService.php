<?php
namespace IComeFromTheNet\Ledger\Service;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use IComeFromTheNet\Ledger\Entity\AccountingEvent;
use IComeFromTheNet\Ledger\Event\EventStore\EventStoreEvent;
use IComeFromTheNet\Ledger\Event\EventStore\EventStoreEvents;
use IComeFromTheNet\Ledger\DB\EventStoreGateway;
use IComeFromTheNet\Ledger\Exception\LedgerException;
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
class AccountingEventService
{
    /*
     * @var IComeFromTheNet\Ledger\DB\EventStoreGateway
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
    public function __construct(EventStoreGateway $eventGateway,EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->eventGateway    = $eventGateway;
        
    }
    
    /**
     *  Receive an accounting Event and store it
     *
     *  @access public
     *  @return void
     *
    */
    public function receive(AccountingEvent $event)
    {
        try {
            # fire the event received
            $this->eventDispatcher->dispatch(EventStoreEvents::EVENT_RECEIVED,new EventStoreEvent($event));
            
            $success = $this->eventGateway->insertQuery()
            ->start()
                ->addColumn('username','ausername')
             ->end()
            ->insert(); 
            
            # update entity with new id
            if($success) {
                $event->setEventId($this->eventGateway->lastInsertId());
            }
            
            # dispatch event
            $this->eventDispatcher->dispatch(EventStoreEvents::EVENT_SAVED,new EventStoreEvent($event));
            
        } catch(DBALException $e) {
            $this->eventDispatcher->dispatch(EventStoreEvents::EVENT_ERROR,new EventStoreEvent($event),$e->getMessage());
            
            # throw exception
            throw new LedgerException($e->getMessage(),0,$e);
        }
        
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
     *  @return IComeFromTheNet\Ledger\Query\EventStoreQuery
     *
    */
    public function findMany()
    {
        return new $this->eventGateway->newQueryBuilder();
    }
}
/* End of Class */