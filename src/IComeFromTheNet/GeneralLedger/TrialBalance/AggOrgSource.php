<?php
namespace IComeFromTheNet\GeneralLedger\TrialBalance;

use DateTime;
use Doctrine\DBAL\Connection;
use IComeFromTheNet\GeneralLedger\Exception\LedgerException;
use Doctrine\DBAL\Types\Type as DoctineType;

/**
 * Will Account balances from the Agg User Database table.
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class AggOrgSource extends AggAllSource 
{
    
    /**
     * @var integer the database id for the ledger Organisation Unit
     */ 
    protected $iOrgID;
    
    
    public function __construct(DateTime $oTrialDate, Connection $oDatabase, $aTableMap, $iOrgID)
    {
        parent::__construct($oTrialDate, $oDatabase, $aTableMap);
        
        $this->iOrgID = $iOrgID;
    }
    
    
    public function getOrg()
    {
        return $this->iOrgID;
    }
    
    
    
    public function getAccountBalances()
    {
        $iOrgId    = $this->getOrg();  
        $oDatabase  = $this->getDatabaseAdapter();
        $oTrialDate = $this->getTrialDate();
        $oTableMap  = $this->getTableMap();
        $sTableName = $oTableMap['ledger_daily'];
        $sSql       = '';
        
        $sSql .=' SELECT sum(balance) as balance, account_id as account_id';
        $sSql .=" FROM $sTableName ";
        $sSql .=' WHERE process_dt <= :toDate AND org_unit_id = :iOrgID ';
        $sSql .=' GROUP BY account_id';
        
        $oSTH = $oDatabase->executeQuery($sSql
                            ,array(':toDate'=> $oTrialDate, ':iOrgID'=>$iOrgId)
                            ,array(DoctineType::getType('date'),DoctineType::getType('integer'))
                            );
        
        
        while ($aResult = $oSTH->fetch(\PDO::FETCH_ASSOC)) {
            $aResult['account_id'] =  DoctineType::getType('integer')->convertToPHPValue($aResult['account_id']);
            $aResult['balance']    =  DoctineType::getType('float')->convertToPHPValue($aResult['balance']);
        }
        
        
        return $aResults;
        
    }
    
    
    
    
}
/* End of File */
