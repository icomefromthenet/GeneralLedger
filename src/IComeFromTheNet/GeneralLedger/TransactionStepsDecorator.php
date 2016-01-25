<?php
namespace IComeFromTheNet\GeneralLedger;

use IComeFromTheNet\GeneralLedger\Entity\LedgerTransaction;
use IComeFromTheNet\GeneralLedger\Entity\LedgerEntry;
use IComeFromTheNet\GeneralLedger\Exception\LedgerException;

/**
 * This decorator executes steps that will save a transaction to the agg tables
 * This should occur after the transction has been saved inside the same DB transaction.
 * 
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class TransactionStepsDecorator implements TransactionProcessInterface, UnitOfWork
{
    
    /**
     * @var TransactionProcessInterface
     */ 
    protected $oProcessor;
    
    /**
     * @var array(TransactionProcessInterface)
     */ 
    protected $aSteps;
    
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
        $this->oProcessor->start();
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
        $this->oProcessor->commit();
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
        $this->oProcessor->rollback();
    }
    
    //--------------------------------------------------------------------------
    # other public methods
    
    /**
     * Class Constructor
     * 
     * @param TransactionProcessInterface   $oProcessor the transaction processor to decorate
     * @param array                         $aSteps     the processing steps to execute    
     */ 
    public function __construct(TransactionProcessInterface $oProcessor, array $aSteps)
    {
        $this->oProcessor = $oProcessor;
        $this->aSteps     = $aSteps;
        
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
     * Return the app logger
     * 
     * @access public
     * @return use Psr\Log\LoggerInterface;
     */ 
    public function getLogger()
    {
        return $this->oProcessor->getLogger();
    }
    
    /**
     * Process a new transaction 
     * 
     * The param $oReversedLedgerTrans is not used here.
     * 
     * Execute the assigned steps in the order they are passed into the constructor.
     * 
     * @param   LedgerTransaction   $oLedgerTrans           The new transaction to make 
     * @param   array               $aLedgerEntries         Array of Ledger Entries (account movements) to save
     * @param   LedgerTransaction   $oAdjustedLedgerTrans   The transaction that is to be reversed by this new transaction
     */  
    public function process(LedgerTransaction $oLedgerTrans, array $aLedgerEntries, LedgerTransaction $oAdjustedLedgerTrans = null)
    {
        # execute the parent process this ensure the basic transction is saved
        $bSuccess = $this->oProcessor->process($oLedgerTrans, $aLedgerEntries, $oAdjustedLedgerTrans);
        
        if(true === $bSuccess) {
            
            if(true === empty($oLedgerTrans->iTransactionID)) {
                throw new LedgerException('The transaction does not have and id assigned unable to process extra steps');
            }
            
            foreach($this->aSteps as $oProcessor) {
                $bSuccess = $oProcessor->process($oLedgerTrans, $aLedgerEntries, $oAdjustedLedgerTrans);
                
                if(false === $bSuccess) {
                    break;
                }
                
            }
            
        }
        
        return $bSuccess;
    }
  
}
/* End of class */