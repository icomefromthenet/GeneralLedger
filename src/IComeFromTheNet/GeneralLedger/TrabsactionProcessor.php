<?php
namespace IComeFromTheNet\GeneralLedger;

use DateTime;
use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use IComeFromTheNet\GeneralLedger\Exception\LedgerException;

/**
 * Commit a transaction to the ledger.
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class TransactionProcessor implements TransactionProcessInterface, UnitOfWork
{
    
    protected $oDatabaseAdapter;
    
    protected $oLogger;
    
    
    //---------------------------------------------------------------------
    # API Methods to control Database Transaction

  
    public function start()
    {
        return true;
    }
    
    
   
    public function commit()
    {
        return true;
    }
    
    
    public function rollback()
    {
        return true;
    }
    
   
    
    //--------------------------------------------------------------------------
    # Public API
    
    public function __construct(Connection $oDatabaseAdapter, LoggerInterface $oLogger)
    {
        $this->oLogger          = $oLogger;
        $this->oDatabaseAdapter = $oDatabaseAdapter;
    }
    
    
    public function process(LedgerTransaction $oLedgerTrans, array $aLedgerEntries, LedgerTransaction $oAdjLedgerTrans = null)
    {
        if(count($aLedgerEntries) === 0) {
            throw new LedgerException('Unable to process a new transction a transaction must have atleast on entry');
        }
        
        $bSuccess = true;
        $sErrorMsg = sprintf('Unable to save ledger transacrtion');
     
        # save the header any database errors will be recorded in the log by the entity 
        if(true === ($bSuccess = $oLedgerTrans->save())) {
            $iTransactionID = $this->getTransactionHeader()->iTransactionID;
            
            # assign new id to each entry and attempt to save it to the database
            foreach($aLedgerEntries as $oEntry) {
                $oEntry->iTransactionID = $iTransactionID;
                
                if(false === ($bSuccess = $oEntry->save())) {
                    $sErrorMsg = sprintf('Unable to save ledger entry at account %s ',$oEntry->sAccountNumber);
                    break;    
                }
            
            }
            
            # assign the new reversal adjustment transction id to the source transaction       
            if(true === $bSuccess && $oAdjLedgerTrans instanceof LedgerTransaction) {
                $oAdjLedgerTrans->iAdjustmentID = $iTransactionID;
                if(false === ($bSuccess = $oAdjLedgerTrans->save())) {
                    $sErrorMsg = sprintf('Unable to link source transaction at id %s to the new adjustment at id %s',$oAdjLedgerTrans->iTransactionID, $iTransactionID);
                }
            }
        
        } 
        
        if($bSuccess === false) {
            $this->getLogger()->error($sErrorMsg);
            throw new LedgerException($sErrorMsg);
        }
        
        return $bSuccess;    
            
    }
     
    
    public function getDatabaseAdapter()
    {
        return $this->oDatabaseAdapter;
    }
    
   
    public function getLogger()
    {
        return $this->oLogger;
    }
    
   
    
}
/* End of Transaction Processor