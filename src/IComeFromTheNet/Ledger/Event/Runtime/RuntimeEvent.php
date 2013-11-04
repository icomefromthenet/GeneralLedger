<?php
namespace IComeFromTheNet\Ledger\Event\Runtime;

use IComeFromTheNet\Ledger\Exception\LedgerException;
use Symfony\Component\EventDispatcher\Event;
use IComeFromTheNet\Ledger\Service\LedgerServiceProvider;

/**
  *  Event object for the LedgerRuntime Events
  *
  *  Stores and instance of the LedgerServiceProvider and an
  *  LedgerException if one is caught by runtime
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class RuntimeEvent extends Event
{
    /*
     * @var IComeFromTheNet\Ledger\Service\LedgerServiceProvider
     */
    protected $ledgerServiceProvider;
    
     /*
     * @var LedgerException an error message
     */
    protected $errorMsg;
   
   
   
    public function __construct(LedgerServiceProvider $service, LedgerException $errorMsg = null)
    {
        $this->edgerServiceProvider  = $service;
        $this->errorMsg              = $errorMsg;
    }
    
    
    /**
     *  Return the Ledger Service Provider
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\Service\LedgerServiceProvider
     *
    */
    public function getLedgerServiceProvider()
    {
        return $this->ledgerServiceProvider;
    }
    
    /**
     *  Return a LedgerException if one is caught
     *
     *  @access public
     *  @return LedgerException
     *
    */
    public function getLedgerException()
    {
        return $this->errorMsg;
    }
}
/* End of Class */



