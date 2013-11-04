<?php
namespace IComeFromTheNet\Ledger;

use IteratorAggregate;
use DateTime;
use Psr\Log\LoggerInterface;
use Doctrine\DBAL\Connection;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use IComeFromTheNet\Ledger\Service\LedgerServiceProvider;
use IComeFromTheNet\Ledger\Event\Runtime\RuntimeEvent;
use IComeFromTheNet\Ledger\Event\Runtime\RuntimeEvents;
use IComeFromTheNet\Ledger\Exception\LedgerException;

/**
  *  Loads a ledger and rules at given a date.
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class LedgerRuntime implements IteratorAggregate 
{
   
   protected $eventDispatcher;
   
   protected $dbal;
   
   protected $logger;
   
   /**
     * 
     * Key-value pairs of data.
     * 
     * @var array
     * 
     */
    protected $data = array();
   
   
   /**
    *  Instance the Ledger Runtime
    *
    *  @access public
    *  @return void
    *  @param EventDispatcherInterface $eventDispatcher the symfony2 event dispatcher
    *  @param Connection $dbal the doctrine DBAL interface
    *  @param LoggerInterface the PSR Logger
    *
   */
   public function __construct(EventDispatcherInterface $eventDispatcher,
                               Connection $dbal,
                               LoggerInterface $logger
                               )
   {
    
    $this->eventDispatcher = $eventDispatcher;
    $this->logger          = $logger;
    $this->dbal            = $dbal;
   }
   
   
   
   /**
    *  Create an instance of the ledger at the given date, if the occuredDate
    *  date not supplied assumed to be same as the processing date.
    *
    *  @access public
    *  @return LedgerServiceProvider
    *  @param DateTime $occuredDate the date in which the event that caused the entry occured.
    *  @param DateTime $processingDate the date the processing occurs commonly NOW
    *
   */ 
   public function assemble(DateTime $processingDate,DateTime $occuredDate = null)
   {
     $ledger = null;
     $index  = null;
     
     try {

        # if the occuredDate date not supplied assumed to be same as the processing date.
        if($occuredDate === null) {
           $occuredDate = clone $processingDate;
        }
        
        # create the internal index
        $index = $this->convertDate($occuredDate);
        
        if(!isset($this->data[$index])) {
           
           # instance the provider and set the required dates
           $ledger = new LedgerServiceProvider($this->eventDispatcher,$this->dbal,$this->logger);
           $ledger->setOccuredDate($occuredDate);
           $ledger->setProcessingDate($processingDate);
           
           # dispatch pre boot event
           $this->eventDispatcher->dispatch(RuntimeEvents::EVENT_RUNTIME_BEFORE_BOOT,new RuntimeEvent($ledger));
            
            # boot the ledger
            $ledger->boot();
           
           # dispatch after boot event
           $this->eventDispatcher->dispatch(RuntimeEvents::EVENT_RUNTIME_AFTER_BOOT,new RuntimeEvent($ledger));
           
           # store this instance in internal cache
           $this->data[$index] = $ledger;
        }
     
     } catch(LedgerException $e) {
        
        $this->eventDispatcher->dispatch(RuntimeEvents::EVENT_RUNTIME_LOAD_FAILED,
                                         new RuntimeEvent($ledger,$e)
                                         );
        throw $e;
        
     } catch(Exception $e) {
        
        $this->eventDispatcher->dispatch(RuntimeEvents::EVENT_RUNTIME_LOAD_FAILED,
                                         new RuntimeEvent($ledger,$e)
                                         );
        throw new LedgerException($e);
     }
     
     return $this->data[$index];
   }
   
   
   /**
    *  Convert date to a string, we dont use a unix timestamp
    *  as the smallest unit is a day and don't want two datetime's
    *  overwrite each other when they both same day but different times.
    *
    *  @access public
    *  @return string a date formatted a string
    *
   */
   protected function convertDate(DateTime $dte)
   {
        return $dte->format('dmY');
   }
    
    
   //-------------------------------------------------------
   # IteratorAggregate Interface
   
   
    /**
     * 
     * IteratorAggregate: returns an external iterator for this struct.
     * 
     * @return DataIterator
     * 
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }
   
}
/* End of Class */
