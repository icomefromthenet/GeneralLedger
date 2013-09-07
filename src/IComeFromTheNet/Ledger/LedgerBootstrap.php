<?php
namespace IComeFromTheNet\Ledger;

use Pimple;

/**
  *  Loads the Dependencies for this component
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class LedgerBootstrap extends Pimple
{
    
    //---------------------------------------------------------
    # Startup
    
    public function boot()
    {
        
        
    }
    
    
    
    
    //---------------------------------------------------------
    # Processing Rules
    
    public function getPostingRules()
    {
        
        
    }
    
    //---------------------------------------------------------
    # Default Accounts
    
    public function getDefaultAccountsInstall()
    {
        
        
    }
    
    
    //---------------------------------------------------------
    # Database Metadata 

    public function getEventSourceDBMeta()
    {
        
    }
    
    
    public function getLedgerTransactionDBMeta()
    {
        
        
    }
    
    public function getAccountDBMeta()
    {
        
    }
    
    public function getAccountGroupDBMeta()
    {
        
    }
    
    public function getAccountEntryDBMeta()
    {
        
        
    }

    //---------------------------------------------------------
    # Database Gateways

    public function getEventSourceTableGateway()
    {
        
    }
    
    public function getAccountTableGateway()
    {
        
    }
    
    public function getLedgerTransactionTableGateway()
    {
        
    }
    
    public function getAccountGroupsTableGateway()
    {
        
    }
    
    public function getAccountEnteriesTableGateway()
    {
        
    }
    
    //---------------------------------------------------------
    # Internal Dep
    
    
    
    
    
    
    public function getGeneralLedgerAPI()
    {
        
        
    }
    
    
    public function getPostingRulesDispatcher()
    {
        
        
    }
    
    
    //---------------------------------------------------------
    # External Dep
    
    
    
    public function getDoctrineDBAL()
    {
        
        
    }
    
    
    public function getLogger()
    {
        
        
    }
    
    
    public function getConsole()
    {
        
        
    }
    
}
/* End of Class */
