<?php
namespace IComeFromTheNet\GeneralLedger;

use DateTime;
use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use IComeFromTheNet\GeneralLedger\Exception\LedgerException;
use IComeFromTheNet\GeneralLedger\Entity\CommonEntity;
use IComeFromTheNet\GeneralLedger\Entity\LedgerTransaction;
use IComeFromTheNet\GeneralLedger\Entity\LedgerEntry;

/**
 * Commit a transaction to the ledger.
 * 
 * Types Transactions.
 * ---------------------------
 * 
 * 1. Entry    
 * 2. Reversal/Adjustment
 * 
 * An entry contains two parts:  
 *  A. A transaction which is stored in the transaction table.
 *  B. A series of account movements which are stored in the entry table.
 * 
 * A reversal is part one of an adjustment a reversal will have the same occured
 * date as the original and have opposing account movments and when combined they will zero out.
 * 
 * An adjustment is the replacement transaction done after a reversal it should have the same occured date as
 * the original and a new set of account movements.
 * 
 * The original transaction will be linked to the reversal we do this so an adjustment can be raised on an adjustment
 * if a mistake is made.
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class TransactionProcessor implements TransactionProcessInterface, UnitOfWork
{
    /**
     * @var Doctrine\DBAL\Connection
     */ 
    protected $oDatabaseAdapter;
    
    /**
     * @var Psr\Log\LoggerInterface
     */ 
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
    
    /**
     * Class constructor
     * 
     * @param   Connection      $oDatabaseAdapter   The DBAL Connection
     * @param   LoggerInterface $oLogger            The app logger
     */
    public function __construct(Connection $oDatabaseAdapter, LoggerInterface $oLogger)
    {
        $this->oLogger          = $oLogger;
        $this->oDatabaseAdapter = $oDatabaseAdapter;
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
        if(count($aLedgerEntries) === 0) {
            throw new LedgerException('Unable to process a new transaction a transaction must have at least one entry');
        }
        
        $bSuccess = true;
        $sErrorMsg = sprintf('Unable to save ledger transacrtion');
     
        # save the header any database errors will be recorded in the log by the entity 
        if(true === ($bSuccess = $oLedgerTrans->save())) {
            $iTransactionID = $oLedgerTrans->iTransactionID;
            
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
                $oAdjustedLedgerTrans->iAdjustmentID = $iTransactionID;
                if(false === ($bSuccess = $oAdjustedLedgerTrans->save())) {
                    $sErrorMsg = sprintf('Unable to link source transaction at id %s to the new adjustment at id %s',$oAdjustedLedgerTrans->iTransactionID, $iTransactionID);
                    $sErrorMsg = $this->buildResultString($sErrorMsg,$oAdjustedLedgerTrans);
                    
                }
            }
        
        } else {
            $sErrorMsg = $this->buildResultString($sErrorMsg,$oLedgerTrans);
        }
        
        
        if($bSuccess === false) {
            $this->getLogger()->error($sErrorMsg);
            throw new LedgerException($sErrorMsg);
        }
        
        return $bSuccess;    
            
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
        return $this->oDatabaseAdapter;
    }
    
    /**
     * Return the app logger
     * 
     * @access public
     * @return use Psr\Log\LoggerInterface;
     */ 
    public function getLogger()
    {
        return $this->oLogger;
    }
    
   
    
}
/* End of Transaction Processor */