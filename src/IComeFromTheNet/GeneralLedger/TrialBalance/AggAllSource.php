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
        
        $sSql .=' SELECT sum(balance) as balance, account_id as account_id';
        $sSql .=" FROM $sTableName ";
        $sSql .=' WHERE process_dt <= :toDate ';
        $sSql .=' GROUP BY account_id';
        
        $oSTH = $oDatabase->executeQuery($sSql,array(':toDate'=> $oTrialDate),array(':toDate'=> DoctineType::getType('date')));
        
        
        $aResults = array();
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
