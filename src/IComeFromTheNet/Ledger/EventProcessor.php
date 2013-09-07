<?php
namespace IComeFromTheNet\Ledger;

use Doctrine\DBAL\Connection;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use IComeFromTheNet\Ledger\Entity\AccountingEvent;
use IComeFromTheNet\Ledger\Exception\LedgerException;
use IComeFromTheNet\Ledger\Event\Unit\UnitEvents;
use IComeFromTheNet\Ledger\Event\Unit\UnitWorkEvent;
use IComeFromTheNet\Ledger\PostingRuleDispatcher;
use IComeFromTheNet\Ledger\AccountingEventStore;
use IComeFromTheNet\Ledger\UnitOfWork;
use SplDoublyLinkedList;

/**
  *  This is a unit of work that ensures both events are
  *  recorded and processed to the GL in an atomic manner
  *
  *  This processor supports 3 modes of operation
  *
  *  1. Complete - Store and Process accounting events to GL
  *  2. Delayed  - Store Events only no processing
  *  3. ProcessOnly - Process events to the GL only.
  *  
  *  Events will be processed in FIFO format
  *
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class EventProcessor extends UnitOfWork
{
    
    const PROCESS_MODE_COMPLETE = 1;
    
    const PROCESS_MODE_DELAYED = 2;
    
    const PROCESS_MODE_PROCESS = 3;
    
    /*
     * @var integer is delayed processing mode
     */
    protected $mode = 1;
    
    /*
     * @var Doctrine\DBAL\Connection the database connection
     */
    protected $dbal;
    
    /*
     * @var Symfony\Component\EventDispatcher\EventDispatcherInterface Event Dispatcher
     */
    protected $event;
    
    /*
     * @var IComeFromTheNet\Ledger\PostingRuleDispatcher
     */
    protected $postingRuleDispatcher;
    
    /*
     * @var IComeFromTheNet\Ledger\AccountingEventStore
     */
    protected $eventStore;
    
    /*
     * @var array container for accounting events
     */
    protected $accountingEvents;
    
   
    
    //---------------------------------------------------------------------
    # API Accessors

    
    public function __construct(Connection $dbal, EventDispatcherInterface $event, AccountingEventStore $accountingEventStore, PostingRuleDispatcher $dispatcher, $mode = self::PROCESS_MODE_COMPLETE)
    {
        
        $this->dbal                  = $dbal;
        $this->event                 = $event;
        $this->postingRuleDispatcher = $dispatcher;
        $this->eventStore            = $accountingEventStore;
        
        $this->setMode((int)$mode);
        
        # create the inner AccountingEvent collection
        $this->clear();

    }
    
    /**
     *  Return the database connection  
     *
     *  @access public
     *  @return  Doctrine\DBAL\Connection
     *
    */
    public function getDBAL()
    {
        return $this->dbal;
    }
    
    /**
     *  Return the Event Dispatcher
     *
     *  @access public
     *  @return Symfony\Component\EventDispatcher\EventDispatcherInterface
     *
    */
    public function getEventDispatcher()
    {
        return $this->event;
    }
    
    /**
     *  Return the accounting event store
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\AccountingEventStore
     *
    */
    public function getAccountingEventStore()
    {
        return $this->eventStore;
    }
    
    /**
     *  Return the mode setting
     *
     *  @access public
     *  @return integer
     *
    */
    public function getMode()
    {
        return $this->mode;
    }
    
     /**
     *  Sets the Processing Mode
     *
     *  @access public
     *  @return void
     *
    */
    public function setMode($mode)
    {
        if($mode !== self::PROCESS_MODE_COMPLETE || $mode !== self::PROCESS_MODE_DELAYED || $mode !== self::PROCESS_MODE_PROCESS) {
            throw new LedgerException(sprinf('Mode set to %s is not a valid option',$mode ));
        }
        
        $this->mode = $mode;
    }
    
    //---------------------------------------------------------------------
    # API Methods to control Database Transaction

    
    /**
     *  Start this unit of work
     *
     *  @access protected
     *  @return void
     *
    */
    protected function start()
    {
        $result = $this->dbal->beginTransaction();
        
        # Fire the StartingEvent
        $this->event->dispatch(UnitEvents::EVENT_START,new UnitWorkEvent($this));
    }
    
    
    /**
     *  Commit the result of the Unit of work
     *
     *  @access protected
     *  @return void
     *
    */
    protected function commit()
    {
        $this->dbal->commit();
        
        # Fire the CommitEvent
        $this->event->dispatch(UnitEvents::EVENT_COMMITTED,new UnitWorkEvent($this));
    }
    
    /**
     *  Cause a rollback of this Unit of Work
     *
     *  @access public
     *  @return void
     *
    */
    protected function rollback()
    {
        $this->dbal->rollBack();
        
        # Fire the RollbackEvent
        $this->event->dispatch(UnitEvents::EVENT_ROLLBACK,new UnitWorkEvent($this));
    }
    
    
    //---------------------------------------------------------------------
    # API Methods to process events and transactions
    
    /**
     *  Add an event to process
     *
     *  @access public
     *  @return void
     *  @param AccountingEvent
     *
    */
    public function add(AccountingEvent $event)
    {
        $this->accountingEvents->push($event);
    }
    
    /**
     *  Clear Events added for processing
     *
     *  @access public
     *  @return void
     *
    */
    public function clear()
    {
        if(isset($this->accountingEvents)) {
            unset($this->accountingEvents);
        }
        
        $this->accountingEvents = new SplDoublyLinkedList();
        $this->accountingEvents->setIteratorMode(SplDoublyLinkedList::IT_MODE_FIFO);    
    }
    
    /**
     *  Process the unit of work
     *
     *  @access public
     *  @return void
     *
    */
    public function process()
    {
        
        try {
            # fire a processing start event before starting transaction
            $this->event->dispatch(EVENT_PROCESSING_START,new UnitWorkEvent($this));
            
            # Open the transaction
            $this->start();
            
            # events need to be stored first
            if($this->getMode() === self::PROCESS_MODE_COMPLETE || $this->mode === self::PROCESS_MODE_DELAYED) {
                $this->storeOnly();
            }
            
            # assume have stored events to process
            if($this->mode === self::PROCESS_MODE_COMPLETE || $this->mode === self::PROCESS_MODE_PROCESS) {
                $this->processOnly();
            }
          
            
            # All is processed, commit the transaction        
            $this->commit();
            $this->event->dispatch(EVENT_PROCESSING_FINISH,new UnitWorkEvent($this));
        
            
        } catch(\Exception $e)  {
            # Been a problem rollback the transaction
            $this->rollback();
            $this->event->dispatch(UnitEvents::EVENT_PROCESSING_ERROR,new UnitWorkEvent($this));
            
            # do something with error
            
        }
        
        
    }
    
    /**
     *  Store AccountingEvents using the EventStore
     *
     *  @access protected
     *  @return void
     *
    */
    protected function storeOnly()
    {
          # process the assigned accounting events
          $accountingEvents = $this->accountingEvents;
            
          for ($accountingEvents->rewind(); $accountingEvents->valid(); $accountingEvents->next()) {
                    
                    $generalLedgerTransaction = null;
                    
                    # check if event has already been stored
                    # this could occur if delayed processing used when event was received
                    $this->getAccountingEventStore()->receive($accountingEvents->current());
                    
                   
          }
    }
    
    /**
     *  Process stored events through dispatcher and commit them to GL
     *
     *  @access protected
     *  @return void
     *
    */
    protected function processOnly()
    {
         $accountingEvents = $this->accountingEvents;
            
          for ($accountingEvents->rewind(); $accountingEvents->valid(); $accountingEvents->next()) {
                    
                    $generalLedgerTransaction = null;
          
                    # Reserve a general Ledger Transaction for this event
                    $generalLedgerTransaction;
                    
                    # Pass this event and transaction through PostingRuleDispatcher
                        
                    # attempt to commit this GeneralLedgerTransaction
          }
         
    }
    
}
/* End of Class */
