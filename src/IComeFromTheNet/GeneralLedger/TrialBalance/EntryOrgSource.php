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
    
    public function getOrg() 
    {
        return $this->iOrgUnitID;
    }
    
    
    public function getAccountBalances()
    {
        
        $oDatabase  = $this->getDatabaseAdapter();
        $oTrialDate = $this->getTrialDate();
        $oTableMap  = $this->getTableMap();
        $iOrgUnitID = $this->getOrg();
        $aResults   = array();
       
        $sEntryTableName       = $oTableMap['ledger_entry'];
        $sTransactionTableName = $oTableMap['ledger_transaction'];
       
        $sSql       = '';
        
        $sSql .=' SELECT sum(e.movement) as balance, e.account_id as account_id ';
        $sSql .=" FROM $sEntryTableName e ";
        $sSql .=" JOIN $sTransactionTableName t on t.transaction_id = e.transaction_id ";
        $sSql .=' WHERE t.process_dt <= :toDate ';
        $sSql .=' AND t.org_unit_id = :iOrgUnitID ';
        $sSql .=' GROUP BY e.account_id';
        $sSql .=' ORDER BY e.account_id';
    
        
        $oSTH = $oDatabase->executeQuery($sSql,array(':toDate'=> $oTrialDate,':iOrgUnitID' => $iOrgUnitID)
                                              ,array(':toDate'=> DoctineType::getType('date'),':iOrgUnitID' => DoctineType::getType('integer')));
        
        
        while ($aResult = $oSTH->fetch(\PDO::FETCH_ASSOC)) {
             $aResults[$oDatabase->convertToPHPValue($aResult['account_id'],'integer')] = array(
                 'balance'    => $oDatabase->convertToPHPValue($aResult['balance'],'float')
                ,'account_id' => $oDatabase->convertToPHPValue($aResult['account_id'],'integer')
            ); 
        }
        
        
        return $aResults;
        
    }
    
    
    
    
}
/* End of File */
