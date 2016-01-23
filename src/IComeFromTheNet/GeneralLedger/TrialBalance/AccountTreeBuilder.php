<?php
namespace IComeFromTheNet\GeneralLedger\TrialBalance;

use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;
use IComeFromTheNet\GeneralLedger\Exception\LedgerException;
use Doctrine\DBAL\Types\Type as DoctineType;

class AccountTreeBuilder
{
    /**
     * @var Psr\Log\LoggerInterface
     */ 
    protected $oLogger;
    
    /**
     * @var Doctrine\DBAL\Connection
     */ 
    protected $oDatabase;
    
    /**
     * @var IComeFromTheNet\GeneralLedger\TrialBalance\DatasourceInterface
     */ 
    protected $oEntrySource;
    
    /**
     * @var array of table names
     */ 
    protected $aTableNames;
    
    /**
     * Fetch list of accounts and relations from the database
     * 
     * @access protected
     * @return array(
     *    'account_id' => integer
     *  , 'parent_account_id' => integer
     *  , 'account_number' => string
     *  , 'account_name' => string
     *  , 'account_name_slug' => string
     *  , 'hide_ui' => boolean
     * )
     */ 
    protected function getAccountList()
    {
        $oDatabase          = $this->getDatabaseAdapter();
        $aTableNames        = $this->aTableNames;
        $sSql               = '';
        $sAccountTable      = $aTableNames['ledger_account'];
        $sAccountGroupTable = $aTableNames['ledger_account_group'];
        
        # assume account only have 1 parent with the root account at index 1    
        
        $sSql .= 'SELECT a.account_id as id, ag.parent_account_id as parent, a.account_number, a.account_name, account_name_slug, a.hide_ui, is_left as is_debit, is_right as is_credit ';
        $sSql .=" FROM $sAccountTable a, $sAccountGroupTable ag ";
        $sSql .=" WHERE a.account_id = ag.child_account_id ";
        
        return $oDatabase->executeQuery($sSql,array(),array(
             DoctineType::getType('integer')
            ,DoctineType::getType('integer')
            ,DoctineType::getType('string')
            ,DoctineType::getType('string')
            ,DoctineType::getType('string')
            ,DoctineType::getType('boolean')
            ,DoctineType::getType('boolean')
            ,DoctineType::getType('boolean')
        ))->fetchAll(\PDO::FETCH_ASSOC);
        
        
    }
    
    /**
     * Load basic balances for each account using and entry source assigned
     * 
     * This does not provider balances for the parents, that must be calculated using the tree
     * 
     * @return void;
     * @param AccountTree $oAccountTree
     * @throws LedgerException
     */ 
    protected function mergeBasicBalances(AccountTree $oAccountTree)
    {
        
        $aBalances = $this->getEntrySource()->getAccountBalances();
        
        try {
        
            foreach($aBalances as $aBal) {
               if($aBal['account_id'] != 1) {
                    $oAccountNode = $oAccountTree->getNodeById($aBal['account_id']);
                    $oAccountNode->setBasicBalance($aBal['balance']);        
               }
            }
            
        } catch (\Exception $e) {
            if($e instanceof LedgerException) {
                throw $e;
            }
            
            throw new LedgerException($e->getMessage(),0,$e);
        }
    }
    
    /**
     * Call the calculate method on the account tree
     * 
     * Catch any tree exceptions and wrap them into ledger exceptions
     * 
     * @param AccountTree $oAccountTree
     * @access protected
     * @throws LedgerException
     */ 
    protected function calculateParentBalances(AccountTree $oAccountTree)
    {
        
        try {
        
           $oAccountTree->calculateCombinedBalances();
            
        } catch (\Exception $e) {
            
            if($e instanceof LedgerException) {
                throw $e;
            }
            
            throw new LedgerException($e->getMessage(),0,$e);
        }
        
    }
    
    //--------------------------------------------------------------------------
    
    public function __construct(Connection $oConnection, LoggerInterface $oLogger, DatasourceInterface $oEntrySource, array $aTableNames)
    {
        $this->aTableNames    = $aTableNames;
        $this->oDatabase      = $oConnection;
        $this->oLogger        = $oLogger;
        $this->oEntrySource   = $oEntrySource;
        
        
    }
    
    
    public function buildAccountTree()
    {
        $aList = $this->getAccountList();
        
        $oAccountTree =  new AccountTree($aList,array('rootid'=> 1));
        
        $this->getAppLogger()->debug('Finished loading account list from database');
        
        $this->mergeBasicBalances($oAccountTree);
        
        $this->getAppLogger()->debug('Finished loading basic balance');
        
        $this->calculateParentBalances($oAccountTree);
        
        $this->getAppLogger()->debug('Account group balances calculatd and account trree frozen');
        
        return $oAccountTree;
    }
    
    
    
    //--------------------------------------------------------------------------
    # Public Properties
    
    
    public function getDatabaseAdapter()
    {
        return $this->oDatabase;    
    }
    
    public function getEntrySource()
    {
        return $this->oEntrySource;
    }
    
    public function getAppLogger()
    {
        return $this->oLogger;
    }
}
/* End of File */
