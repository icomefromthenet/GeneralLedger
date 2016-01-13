<?php
namespace IComeFromTheNet\GeneralLedger\Step;

use IComeFromTheNet\GeneralLedger\Exception\LedgerException;
use IComeFromTheNet\GeneralLedger\Entity\LedgerTransaction;
use IComeFromTheNet\GeneralLedger\Entity\LedgerEntry;
use Doctrine\DBAL\Types\Type as DoctineType;

/**
 * This will calculate the daily AGG for each account in the transaction.
 * 
 * If your not using the AGG tables then this step should not be used.
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class AggAllStep extends CommonStep
{
    
    
    
    
    public function process(LedgerTransaction $oLedgerTrans, array $aLedgerEntries, LedgerTransaction $oAdjustedLedgerTrans = null)
    {
        $oDatabase = $this->getDatabaseAdapter();
        $aTableMap = $this->getTableMap();
        $sTableName = $aTableMap['ledger_daily'];
        
        $sSql  = '';
        $sSql  .=" INSERT INTO $sTableName (process_dt, account_id, balance) ";
        $sSql  .=" VALUES (:oProcessDate, :iAccountId, :fMovement) ";
        $sSql  .=" ON DUPLICATE KEY UPDATE balance = balance + VALUES(balance) ";
        
        $aTypes = array(
           ':oProcessDate' =>  DoctineType::getType('date')
          ,':iAccountId'   => DoctineType::getType('integer')
          ,':fMovement'    => DoctineType::getType('float')
        );
        
        foreach($aLedgerEntries as  $oMovement) {
            $bResult = $oDatabase->executeUpdate($sSql
                                     ,array( ':oProcessDate' => $oLedgerTrans->oProcessingDate
                                            , ':iAccountId'  => $oMovement->iAccountID
                                            , ':fMovement'   => $oMovement->fMovement)
                                     ,$aTypes);
                                     
            if(false === $bResult) {
        
                $sMessage = sprintf('Unable to process AGG entry for account %s for value %s',$oMovement->iAccountID,$oMovement->fMovement);
                
                $this->getLogger()->debug($sMessage);
                
                throw new LedgerException($sMessage);
                
            } else {
                
                $sMessage = sprintf('Processed AGG entry for account %s for value %s',$oMovement->iAccountID,$oMovement->fMovement);
                
                $this->getLogger()->debug($sMessage);
                
            }                          

        }
        
    }

}
/* End of class */



