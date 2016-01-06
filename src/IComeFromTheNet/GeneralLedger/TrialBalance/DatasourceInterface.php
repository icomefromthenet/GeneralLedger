<?php
namespace IComeFromTheNet\GeneralLedger\TrialBalance;

interface DatasourceInterface
{
    /**
     * Return the database adapter
     * 
     * @return Doctrine\DBAL\Connection
     */ 
    public function getDatabaseAdapter();
    
    /**
     * Return a map of interal/actual tablenames
     * 
     * @return array
     */ 
    public function getTableMap();
    
    /**
     * Load the account balances UpToTheCurrentDate
     * 
     * @return array[account_id] => balance
     */ 
    public function getAccountBalances();
    
    /**
     * Date the trail is run on.
     * 
     * @return DateTime
     */ 
    public function getTrialDate();
    
}
/* End of File */