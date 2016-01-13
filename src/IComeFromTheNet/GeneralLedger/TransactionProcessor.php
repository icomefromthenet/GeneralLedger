<?php
namespace IComeFromTheNet\GeneralLedger;

use DateTime;
use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use IComeFromTheNet\GeneralLedger\Exception\LedgerException;
use IComeFromTheNet\GeneralLedger\Entity\CommonEntity;

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
    
    
    /**
     * Build a string of the last result, if the entity failed
     * validation it could return a multi-line message.
     * 
     * @return string a last result string for the debug log
     * @param CommonEntity an entity that has a result
     */ 
    protected function buildResultString($sHeaderMessage,CommonEntity $oEntity)
    {
        $aLastResult = $oEntity->getLastQueryResult();
        
        $sMessage = '';
        
        if(is_array($aLastResult['msg'])) {
            
            // this would come from the entity validation library failing.
            foreach($aLastResult['msg'] as $sColumn => $aValidationError) {
            
                $sMessage .= "$sColumn caused the following validation errors: " . PHP_EOL;
            
                foreach($aValidationError as $sMessage) {
                    $sMessage .= chr(9).$sMessage.PHP_EOL;
                }
                
                $sMessage .= PHP_EOL;
            }
            
        } else {
            $sMessage = $aLastResult['msg'];
        }
        
        
        return $sHeaderMessage . PHP_EOL . $sMessage;
        
    }
    
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
    
    
    public function process(LedgerTransaction $oLedgerTrans, array $aLedgerEntries, LedgerTransaction $oAdjustedLedgerTrans = null)
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
                    $sErrorMsg = $this->buildResultString($sErrorMsg,$oEntry);
                
                    break;    
                }
            
            }
            
            # assign the new reversal adjustment transction id to the source transaction       
            if(true === $bSuccess && $oAdjustedLedgerTrans instanceof LedgerTransaction) {
                $oAdjLedgerTrans->iAdjustmentID = $iTransactionID;
                if(false === ($bSuccess = $oAdjLedgerTrans->save())) {
                    $sErrorMsg = sprintf('Unable to link source transaction at id %s to the new adjustment at id %s',$oAdjLedgerTrans->iTransactionID, $iTransactionID);
                    $sErrorMsg = $this->buildResultString($sErrorMsg,$oAdjLedgerTrans);
                    
                }
            }
        
        } else {
            $sErrorMsg = $this->buildResultString($sErrorMsg,$oEntry);
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