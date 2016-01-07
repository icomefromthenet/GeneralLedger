<?php
namespace IComeFromTheNet\GeneralLedger\TrialBalance;

use DateTime;
use Doctrine\DBAL\Connection;
use IComeFromTheNet\GeneralLedger\Exception\LedgerException;
use Doctrine\DBAL\Types\Type as DoctineType;

/**
 * Will Account balances use the entry for a single ledger user database tables.
 * This require a join onto the transaction table so be less performant than using the AGG tables.
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class EntryUserSource implements DatasourceInterface
{
    
    
    protected $oDatabase;
    
    protected $oTrialDate;
    
    protected $aTableMap;
    
    protected $iUserID;
    
    public function __construct(DateTime $oTrialDate, Connection $oDatabase, $aTableMap, $iUserID)
    {
        $this->aTableMap  = $aTableMap;
        $this->oTrialDate = $oTrialDate;
        $this->oDatabase  = $oDatabase;
        $this->iUserID    = $iUserID;
        
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
    
    public function getLedgerUser()
    {
        return $this->iUserID;
    }
    
    
    public function getAccountBalances()
    {
        
        $oDatabase  = $this->getDatabaseAdapter();
        $oTrialDate = $this->getTrialDate();
        $oTableMap  = $this->getTableMap();
        $iUserID    = $this->getLedgerUser();
       
        $sEntryTableName       = $oTableMap['ledger_transaction'];
        $sTransactionTableName = $oTableMap['ledger_entry'];
       
        $sSql       = '';
        
        $sSql .=' SELECT sum(e.movement) as balance, e.account_id as account_id ';
        $sSql .=" FROM $sEntryTableName e ";
        $sSql .=" JOIN $sTransactionTableName t on t.transaction_id = e.transaction_id ";
        $sSql .=' WHERE process_dt <= :toDate ';
        $sSql .=' AND t.iOrgUnitID = :iUserID ';
        $sSql .=' GROUP BY account_id';
        
        $oSTH = $oDatabase->executeQuery($sSql,array(':toDate'=> $oTrialDate,':iOrgUnitID' => $iUserID)
                                              ,array(DoctineType::getType('date'),DoctineType::getType('integer')));
        
        
        while ($aResult = $oSTH->fetch(\PDO::FETCH_ASSOC)) {
            $aResult['account_id'] =  DoctineType::getType('integer')->convertToPHPValue($aResult['account_id']);
            $aResult['balance']    =  DoctineType::getType('float')->convertToPHPValue($aResult['balance']);
        }
        
        
        return $aResults;
        
    }
    
    
    
    
}
/* End of File */
