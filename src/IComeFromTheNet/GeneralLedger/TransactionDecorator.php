<?php
namespace IComeFromTheNet\GeneralLedger;

use IComeFromTheNet\GeneralLedger\Entity\LedgerTransaction;
use IComeFromTheNet\GeneralLedger\Entity\LedgerEntry;
use IComeFromTheNet\GeneralLedger\Exception\LedgerException;

/**
 * This provide the actions to manage a database transaction.
 * 
 * If your processing in bulk you many want to manage the transaction yourself this
 * could be optional step. 
 * 
 * This class should be the last decorator attached to a transaction processor.
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class TransactionDecorator implements TransactionProcessInterface, UnitOfWork
{
    
    /**
     * @var TransactionProcessInterface
     */ 
    protected $oProcessor;
    
    //---------------------------------------------------------------------
    # API Methods to control Database Transaction
    
    /**
     *  Start this unit of work
     *
     *  @access protected
     *  @return void
     *
    */
    public function start()
    {
        $this->getDatabaseAdapter()->beginTransaction();
    }
    
    
    /**
     *  Commit the result of the Unit of work
     *
     *  @access protected
     *  @return void
     *
    */
    public function commit()
    {
        $this->getDatabaseAdapter()->commit();
    }
    
     /**
     *  Cause a rollback of this Unit of Work
     *
     *  @access public
     *  @return void
     *
    */
    public function rollback()
    {
        $this->getDatabaseAdapter()->rollback();
    }
    
    //--------------------------------------------------------------------------
    # other public methods
    
    public function __construct(TransactionProcessInterface $oProcessor)
    {
        $this->oProcessor = $oProcessor;
        
    }
    
    public function getDatabaseAdapter()
    {
        return $this->oProcessor->getDatabaseAdapter();
    }
    
    public function getLogger()
    {
        return $this->oProcessor->getLogger();
    }
    
    public function process(LedgerTransaction $oLedgerTrans, array $aLedgerEntries, LedgerTransaction $oAdjLedgerTrans = null)
    {
        return $this->oProcessor->process($oLedgerTrans, $aLedgerEntries, $oAdjLedgerTrans);
    }
  
}
/* End of class */



