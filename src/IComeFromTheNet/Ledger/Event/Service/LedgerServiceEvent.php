<?php
namespace IComeFromTheNet\Ledger\Event\Ledger;

use Symfony\Component\EventDispatcher\Event;
use IComeFromTheNet\Ledger\Entity\LedgerTransaction;

/**
  *  Event object for the AccountEventsStore
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class LedgerTransactionEvent extends Event
{
    /*
     * @var IComeFromTheNet\Ledger\Entity\LedgerTransaction
     */
    protected $transaction;
    
     /*
     * @var string an error message
     */
    protected $errorMsg;
   
   
   
    public function __construct(LedgerTransaction $transaction,$errorMsg = '')
    {
        $this->transaction  = $transaction;
        $this->errorMsg     = $errorMsg;
    }
    
    
    /**
     *  Return the Unit of Work
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\Entity\LedgerTransaction
     *
    */
    public function getLedgerTransaction()
    {
        return $this->transaction;
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



