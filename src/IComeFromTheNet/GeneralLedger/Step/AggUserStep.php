<?php
namespace IComeFromTheNet\GeneralLedger\Step;

use IComeFromTheNet\GeneralLedger\Entity\LedgerTransaction;
use IComeFromTheNet\GeneralLedger\Entity\LedgerEntry;

/**
 * This will calculate the daily AGG for each account and the transacions user
 * 
 * If your not using the AGG tables then this step should not be used.
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class AggUserStep extends CommonStep
{
    
    
    
    
    public function process(LedgerTransaction $oLedgerTrans, array $aLedgerEntries, LedgerTransaction $oAdjLedgerTrans = null)
    {
         $oDatabase = $this->getDatabaseAdapter();
        $aTableMap = $this->getTableMap();
        $sTableName = $aTableMap['ledger_daily_user'];
        
        $sSql  = '';
        $sSql  .=" INSERT INTO $sTableName (process_dt, account_id, balance, user_id) ";
        $sSql  .=" VALUES (:oProcessDate, :iAccountId, :fMovement, :iUserId) ";
        $sSql  .=" ON DUPLICATE KEY UPDATE balance = balance + VALUES(balance) ";
        
        $aTypes = array(
           DoctineType::getType('date')
          ,DoctineType::getType('integer')
          ,DoctineType::getType('float')
          ,DoctineType::getType('integer')
        );
        
        foreach($aLedgerEntries as  $oMovement) {
           
            $bResult = $oDatabase->executeUpdate($sSql
                                     ,array( ':oProcessDate' => $oLedgerTrans->oProcessingDate
                                            , ':iAccountId'  => $oMovement->iAccountID
                                            , ':fMovement'   => $oMovement->fMovement
                                            , ':iUserId'     => $oMovement->iUserID)
                                     ,$aTypes);
            
            
                                     
            if(false === $bResult) {
                
                $sMessage = sprintf('Unable to process AGG entry for account %s user %s for value %s',$oMovement->iAccountID,$oMovement->iUserID,$oMovement->fMovement);
                
                $this->getLogger()->debug($sMessage);
                
                throw new LedgerException($sMessage);
            }                         
            else {
     
                $sMessage = sprintf('Processed AGG entry for account %s user %s for value %s',$oMovement->iAccountID,$oMovement->iUserID,$oMovement->fMovement);
                
                $this->getLogger()->debug($sMessage);
                
            }
            
        }
                
    }

}
/* End of class */



