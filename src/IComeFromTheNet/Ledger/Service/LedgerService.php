<?php
namespace IComeFromTheNet\Ledger;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use IComeFromTheNet\Ledger\Entity\LedgerTransaction;
use IComeFromTheNet\Ledger\Entity\AccountEntry;
use IComeFromTheNet\Ledger\DB\LedgerTransactionGateway;
use IComeFromTheNet\Ledger\Event\Ledger\LedgerTransactionEvent;
use IComeFromTheNet\Ledger\Event\Ledger\LedgerTransactionEvents;
use IComeFromTheNet\Ledger\Exception\LedgerException;


/**
  *  Store of General Ledger Transaction
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class LedgerService
{
    
    /*
     * @var IComeFromTheNet\Ledger\DB\EventStoreGateway
     */
    protected $transactionGateway;
    
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
    public function __construct(LedgerTransactionGateway $transactionGateway,EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher       = $eventDispatcher;
        $this->transactionGateway    = $transactionGateway;
        
    }
    
    /**
     *  Saves new account entry,
     *  will update the entry with storage id
     *
     *  @access public
     *  @return boolean true if sucessful
     *
    */
    public function newAccountEntry(AccountEntry $entry)
    {
        
        
    }
    
    /**
     *  Find a one account entry
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\Entity\AccountEntry
     *
    */
    public function findOneAccountEntry()
    {
        
        
    }
    
    /**
     *  Find a ledger transaction by its storage id
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\Entity\AccountEntry
     *
    */
    public function findManyAccountEntry()
    {
        
    }
    
    /**
     *  Find a ledger transaction by its storage id
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\Query\LedgerTransactionQuery
     *
    */
    public function newLedgerTransaction(LedgerTransaction $transaction)
    {
       try {
            # fire the event received
            $this->eventDispatcher->dispatch(LedgerTransactionEvent::EVENT_RECEIVED,new LedgerTransactionEvent($transaction));
            
            $success = $this->eventGateway->insertQuery()
            ->start()
                ->addColumn('username','ausername')
             ->end()
            ->insert(); 
            
            # update entity with new id
            if($success) {
                $transaction->setTransactionId($this->eventGateway->lastInsertId());
            }
            
            # dispatch event
            $this->eventDispatcher->dispatch(LedgerTransactionEvent::EVENT_SAVED,new LedgerTransactionEvent($transaction));
            
        } catch(DBALException $e) {
            $this->eventDispatcher->dispatch(LedgerTransactionEvent::EVENT_ERROR,new LedgerTransactionEvent($transaction),$e->getMessage());
            
            # throw exception
            throw new LedgerException($e->getMessage(),0,$e);
        }
    }
    
        
    /**
     *  Find a ledger transaction by its storage id
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\Query\LedgerTransactionQuery
     *
    */
    public function findOneLedgerTransaction($id)
    {
       $obj = null;
       
       $query = new $this->transactionGateway->newQueryBuilder();
       
       
       
       
       return $obj;
    }
    
    /**
     *  Find a single ledger transaction by voucher
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\Query\LedgerTransactionQuery
     *
    */
    public function findOneLedgerTransactionByVoucher()
    {
        
        
    }
    
    
    /**
     *  Select and filter a search 
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\Query\LedgerTransactionQuery
     *
    */
    public function findManyTransaction()
    {
        return new $this->transactionGateway->newQueryBuilder();
    }
    
    
    
}
/* End of Class */
