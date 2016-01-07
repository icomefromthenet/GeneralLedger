<?php
namespace IComeFromTheNet\GeneralLedger\TrialBalance;

use DateTime;
use Doctrine\DBAL\Connection;
use IComeFromTheNet\GeneralLedger\Exception\LedgerException;
use Doctrine\DBAL\Types\Type as DoctineType;

/**
 * Will Account balances use the entry for a single orgunit database tables.
 * This require a join onto the transaction table so be less performant than using the AGG tables.
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class EntryOrgSource implements DatasourceInterface
{
    
    
    protected $oDatabase;
    
    protected $oTrialDate;
    
    protected $aTableMap;
    
    protected $iOrgUnitID;
    
    public function __construct(DateTime $oTrialDate, Connection $oDatabase, $aTableMap, $iOrgUnitID)
    {
        $this->aTableMap  = $aTableMap;
        $this->oTrialDate = $oTrialDate;
        $this->oDatabase  = $oDatabase;
        $this->iOrgUnitID = $iOrgUnitID;
        
    }
    
    
    
    public function getDatabaseAdapter()
    {
        return $this->oDatabase;
    }
    
    
    public function getTableMap()
    {
        return $this->aTableMap;
    }
    
    public function getTrialDate()
    {
        return $this->oTrialDate;
    }
    
    public function getOrgUnit()
    {
        return $this->iOrgUnitID;
    }
    
    
    public function getAccountBalances()
    {
        
        $oDatabase  = $this->getDatabaseAdapter();
        $oTrialDate = $this->getTrialDate();
        $oTableMap  = $this->getTableMap();
        $iOrgUnitID = $this->getOrgUnit();
       
        $sEntryTableName       = $oTableMap['ledger_transaction'];
        $sTransactionTableName = $oTableMap['ledger_entry'];
       
        $sSql       = '';
        
        $sSql .=' SELECT sum(e.movement) as balance, e.account_id as account_id ';
        $sSql .=" FROM $sEntryTableName e ";
        $sSql .=" JOIN $sTransactionTableName t on t.transaction_id = e.transaction_id ";
        $sSql .=' WHERE process_dt <= :toDate ';
        $sSql .=' AND t.org_unit_id = :iOrgUnitID ';
        $sSql .=' GROUP BY account_id';
        
        $oSTH = $oDatabase->executeQuery($sSql,array(':toDate'=> $oTrialDate,':iOrgUnitID' => $iOrgUnitID)
                                              ,array(DoctineType::getType('date'),DoctineType::getType('integer')));
        
        
        while ($aResult = $oSTH->fetch(\PDO::FETCH_ASSOC)) {
            $aResult['account_id'] =  DoctineType::getType('integer')->convertToPHPValue($aResult['account_id']);
            $aResult['balance']    =  DoctineType::getType('float')->convertToPHPValue($aResult['balance']);
        }
        
        
        return $aResults;
        
    }
    
    
    
    
}
/* End of File */
