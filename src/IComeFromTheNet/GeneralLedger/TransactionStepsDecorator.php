<?php
namespace IComeFromTheNet\GeneralLedger;

use IComeFromTheNet\GeneralLedger\Entity\LedgerTransaction;
use IComeFromTheNet\GeneralLedger\Entity\LedgerEntry;
use IComeFromTheNet\GeneralLedger\Exception\LedgerException;

/**
 * This execute assigned steps that should occur after the transction has been saved.
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
    
    public function getDatabaseAdapter()
    {
        return $this->oProcessor->getDatabaseAdapter();
    }
    
    public function getLogger()
    {
        return $this->oProcessor->getLogger();
    }
    
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



