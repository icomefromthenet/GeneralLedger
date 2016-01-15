<?php
namespace IComeFromTheNet\GeneralLedger\Step;

use IComeFromTheNet\GeneralLedger\Exception\LedgerException;
use IComeFromTheNet\GeneralLedger\Entity\LedgerTransaction;
use IComeFromTheNet\GeneralLedger\Entity\LedgerEntry;
use Doctrine\DBAL\Types\Type as DoctineType;

/**
 * This will calculate the daily AGG for each account and org unit.
 * 
 * If your not using the AGG tables then this step should not be used.
 * 
 * Only save the org unit of this transaction.
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class AggOrgUnitStep extends CommonStep
{
    
    
    
    
    public function process(LedgerTransaction $oLedgerTrans, array $aLedgerEntries, LedgerTransaction $oAdjustedLedgerTrans = null)
    {
        $oDatabase = $this->getDatabaseAdapter();
        $aTableMap = $this->getTableMap();
        $sTableName = $aTableMap['ledger_daily_org'];
        
        $sSql  = '';
        $sSql  .=" INSERT INTO $sTableName (process_dt, account_id, balance, org_unit_id) ";
        $sSql  .=" VALUES (:oProcessDate, :iAccountId, :fMovement, :iOrgUnitId) ";
        $sSql  .=" ON DUPLICATE KEY UPDATE balance = balance + VALUES(balance) ";
        
        $aTypes = array(
          ':oProcessDate'  => DoctineType::getType('date')
          ,':iAccountId'   => DoctineType::getType('integer')
          ,':fMovement'    => DoctineType::getType('float')
          ,':iOrgUnitId'   => DoctineType::getType('integer')
        );
        
        foreach($aLedgerEntries as  $oMovement) {
            $bResult = $oDatabase->executeUpdate($sSql
                                     ,array( ':oProcessDate' => $oLedgerTrans->oProcessingDate
                                            , ':iAccountId'  => $oMovement->iAccountID
                                            , ':fMovement'   => $oMovement->fMovement
                                            , ':iOrgUnitId'  => $oLedgerTrans->iOrgUnitID)
                                     ,$aTypes);
                                     
            if(false === $bResult) {
            
                $sMessage = sprintf('Unable to process AGG entry for account %s orgUnit %s for value %s',$oMovement->iAccountID,$oLedgerTrans->iOrgUnitID,$oMovement->fMovement);
                
                $this->getLogger()->debug($sMessage);
                
                throw new LedgerException($sMessage);
                
            } else {
           
                $sMessage = sprintf('Processed AGG entry for account %s orgUnit %s for value %s',$oMovement->iAccountID,$oLedgerTrans->iOrgUnitID,$oMovement->fMovement);
                
                $this->getLogger()->debug($sMessage);
                
            }

        }
                
    }

}
/* End of class */



