<?php
namespace IComeFromTheNet\GeneralLedger;

use IComeFromTheNet\GeneralLedger\Entity\LedgerTransaction;
use IComeFromTheNet\GeneralLedger\Entity\LedgerEntry;
use IComeFromTheNet\GeneralLedger\Exception\LedgerException;

/**
 * This provides the actions to manage a database transaction.
 * 
 * If your processing in bulk you many want to manage the transaction yourself this
 * could be optional. 
 * 
 * This class should be the last decorator attached to a transaction processor.
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class TransactionDBDecorator implements TransactionProcessInterface, UnitOfWork
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
    */
    public function rollback()
    {
        $this->getDatabaseAdapter()->rollback();
    }
    
    //--------------------------------------------------------------------------
    # other public methods
    
    /**
     * Class Constructor
     * 
     * @param TransactionProcessInterface   $oProcessor The processor to provide a transaction too.
     */ 
    public function __construct(TransactionProcessInterface $oProcessor)
    {
        $this->oProcessor = $oProcessor;
    }
    
    /**
     *  Return the database connection  
     *
     *  @access public
     *  @return  Doctrine\DBAL\Connection
     *
    */
    public function getDatabaseAdapter()
    {
        return $this->oProcessor->getDatabaseAdapter();
    }
    
    /**
     * Gets the database adapter
     * 
     * @return Psr\Log\LoggerInterface
     */ 
    public function getLogger()
    {
        return $this->oProcessor->getLogger();
    }
    
    /**
     * Process a new transaction 
     * 
     * The param $oReversedLedgerTrans is only required if creating a reversal.
     * 
     * @param   LedgerTransaction   $oLedgerTrans           The new transaction to make 
     * @param   array               $aLedgerEntries         Array of Ledger Entries (account movements) to save
     * @param   LedgerTransaction   $oAdjustedLedgerTrans   The transaction that is to be reversed by this new transaction
     */ 
    public function process(LedgerTransaction $oLedgerTrans, array $aLedgerEntries, LedgerTransaction $oAdjustedLedgerTrans = null)
    {
        return $this->oProcessor->process($oLedgerTrans, $aLedgerEntries, $oAdjustedLedgerTrans);
    }
  
    
}
/* End of class */



