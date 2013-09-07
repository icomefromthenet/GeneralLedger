<?php
namespace IComeFromTheNet\Ledger\Processing;

use IComeFromTheNet\Ledger\Exception\LedgerException;
use IComeFromTheNet\Ledger\Entity\AccountingEvent;
use IComeFromTheNet\Ledger\Entity\LedgerTransaction;

/**
  *  This context class is passed between posting rules in a filter chain
  *
  *  It will contain A LedgerTransaction, AccountingEvent and merge isself
  *  with internal LOB (memorandum) so properties can be accessed with getters/setters.
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class TransactionContext
{
    
    protected $accountingEvent;
    
    protected $ledgerTransaction;
    
    protected $internal;
    
    
    /**
     *  Class Constructor
     *
     *  @access public
     *  @return void
     *  @param array $lob the data to map internally
     *  @param AccountingEvent $accountingEvent
     *  @param LedgerTransaction $ledgerTransaction
     *
    */
    public function __construct($lob = array(), AccountingEvent $accountingEvent, LedgerTransaction $ledgerTransaction)
    {
        if(!is_array($lob)) {
            throw new LedgerException('$lob param must be an array');
        }
        
        $this->internal          = $lob;
        $this->accountingEvent   = $accountingEvent;
        $this->ledgerTransaction = $ledgerTransaction;
        
    }
    
    /**
     *  Fetch a param
     *
     *  @access public
     *  @return mixed a param
     *  @param string $param the key name
     *
    */
    public function get($param)
    {
        return $this->internal[$param];
    }
    
    /**
     *  Set a param
     *
     *  @access public
     *  @return void
     *  @param string $param the key name
     *  @param mixed  $value the value
     *
    */
    public function set($param,$value)
    {
        $this->internal[$param] = $value;
    }
    
    /**
     *  Run isset on the given param
     *
     *  @access public
     *  @return boolean true if exists
     *
    */
    public function exists($param)
    {
        return isset($this->internal[$param]);
    }
    
    /**
     *  Return the assigned Ledger Transaction
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\Entity\LedgerTransaction
     *
    */
    public function getLedgerTransaction()
    {
        return $this->ledgerTransaction;
    }
    
    /**
     *  Return the assigned AccountingEvent
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
