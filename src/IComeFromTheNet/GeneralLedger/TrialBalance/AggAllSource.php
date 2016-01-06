<?php
namespace IComeFromTheNet\GeneralLedger\TrialBalance;

use DateTime;
use Doctrine\DBAL\Connection;
use IComeFromTheNet\GeneralLedger\Exception\LedgerException;
use Doctrine\DBAL\Types\Type as DoctineType;

/**
 * Will Account balances from the Agg All Database table.
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class AggAllSource implements DatasourceInterface
{
    
    
    protected $oDatabase;
    
    protected $oTrialDate;
    
    protected $aTableMap;
    
    
    
    public function __construct(DateTime $oTrialDate, Connection $oDatabase, $aTableMap)
    {
        $this->aTableMap  = $aTableMap;
        $this->oTrialDate = $oTrialDate;
        $this->oDatabase  = $oDatabase;
        
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
    
    
    public function getAccountBalances()
    {
        
        $oDatabase  = $this->getDatabaseAdapter();
        $oTrialDate = $this->getTrialDate();
        $oTableMap  = $this->getTableMap();
        $sTableName = $oTableMap['ledger_daily'];
        $sSql       = '';
        
        $sSql .=' SELECT sum(balance) as BALANCE, account_id as ACCOUNT_ID';
        $sSql .=" FROM $sTableName ";
        $sSql .=' WHERE process_date <= :toDate ';
        $sSql .=' GROUP BY account_id';
        
        $oSTH = $oDatabase->executeQuery($sSql,array(':toDate'=> $oTrialDate),array(DoctineType::getType('date')));
        
        
        while ($aResult = $oSTH->fetch(\PDO::FETCH_ASSOC)) {
            $aResult['account_id'] =  DoctineType::getType('integer')->convertToPHPValue($aResult['account_id']);
            $aResult['balance']    =  DoctineType::getType('float')->convertToPHPValue($aResult['balance']);
        }
        
        
        return $aResults;
        
    }
    
    
    
    
}
/* End of File */
