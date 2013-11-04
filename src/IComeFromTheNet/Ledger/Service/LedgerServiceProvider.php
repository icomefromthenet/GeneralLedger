<?php
namespace IComeFromTheNet\Ledger\Service;

use DateTime;
use Pimple;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;

/**
  *  Loads the Dependencies for this component
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class LedgerServiceProvider extends Pimple
{
    
    
    protected function setupMetaDefinitions()
    {
         $this['account_group_db_meta'] = $this->share(function($c) {
            $table = new \DBALGateway\Metadata\Table('ledger_account_group');
            $table->addColumn("group_id", "integer", array("unsigned" => true));
            $table->addColumn("group_name", "string", array("length" => 50));
            $table->addColumn("group_description", "string", array("length" => 150));
            $table->addColumn("group_date_added", "date",array());
            $table->addColumn("group_date_removed", "date",array());
            $table->addColumn("parent_group_id", "integer", array("unsigned" => true,'notnull'=> false));
            $table->setPrimaryKey(array("group_id"));
            $table->addForeignKeyConstraint($table,  array("parent_group_id"), array("group_id"), array("onUpdate" => "CASCADE"));
        
            return $table;
        }); 
            
        $this['account_db_meta'] = $this->share(function($c){
           
            $accountTable = new \DBALGateway\Metadata\Table("ledger_account");
            $accountTable->addColumn("account_number", "integer", array("unsigned" => true));
            $accountTable->addColumn("account_name","string",array('length' => 50));
            $accountTable->addColumn("account_date_opened", "date",array());
            $accountTable->addColumn("account_date_closed", "date",array());
            $accountTable->addColumn("account_group_id", "integer", array("unsigned" => true));
            $accountTable->setPrimaryKey(array("account_number"));
            $accountTable->addForeignKeyConstraint($this['account_group_db_meta'], array("account_group_id"), array("group_id"), array("onUpdate" => "CASCADE")); 
            
            return $accountTable;            
        });
          
    }
    
    
    protected function setupTableGateways()
    {
        $this['account_group_entity_builder'] = $this->share(function($c){
            return new \IComeFromTheNet\Ledger\DB\AccountGroupBuilder();    
        });
        
        
        $this['account_entity_builder'] = $this->share(function($c){
            return new \IComeFromTheNet\Ledger\DB\AccountBuilder();
        });
         
         
         $this['account_group_table_gateway'] = $this->share(function($c) {
                return new \IComeFromTheNet\Ledger\DB\AccountGroupGateway('ledger_account_group',
                                                                          $c->getDoctrineDBAL(),
                                                                          $c->getEventDispatcher(),
                                                                          $c['account_group_db_meta'],
                                                                          null,
                                                                          $c->getAccountGroupEntityBuilder()
                                                                          );
        });  
        
        
        
        $this['account_table_gateway'] = $this->share(function($c){
           return new \IComeFromTheNet\Ledger\DB\AccountGateway ('ledger_account',
                                                                $c->getDoctrineDBAL(),
                                                                $c->getEventDispatcher(),
                                                                $c['account_db_meta'],
                                                                null,
                                                                $c->getAccountEntityBuilder()
                                                                );
            
        });
        
        
    }
    
    
    protected function setupServiceManagers()
    {
        
        $this['service_managers_account'] = $this->share(function(LedgerServiceProvider $c){
           return new \IComeFromTheNet\Ledger\Service\AccountManagerService($c['now'],
                                                                            $c->getEventDispatcher(),
                                                                            $c->getAccountGroupTableGateway(),
                                                                            $c->getAccountTableGateway()); 
            
        });
        
    }
    
    /**
     *  Class Constructor
     *
     *  @access public
     *  @return void
     *
    */
    public function __construct(EventDispatcherInterface $event, Connection $doctrine, LoggerInterface $logger)
    {
        $this['symfony_eventdispatcher']= $event;
        $this['doctrine_dbal']          = $doctrine;
        $this['psr_log']                = $logger;
    }
    
    
    //---------------------------------------------------------
    # Startup
    
    public function boot()
    {
        
        $this->setupMetaDefinitions();
        $this->setupTableGateways();
        $this->setupServiceManagers();
       
        
    }
    
    //---------------------------------------------------------
    # Service Managers
    
    /**
     *  Return the Account Service Manager
     *  Used to Manage Accounts and Account Groups
     *
     *  @access public
     *  @return \IComeFromTheNet\Ledger\Service\AccountManagerService
     *
    */
    public function getAccountServiceManager()
    {
        return $this['service_managers_account'];
    }
    
    
    //---------------------------------------------------------
    # Processing Rules
    
    public function getPostingRules()
    {
        
        
    }
    
    
    //---------------------------------------------------------
    # Database Gateways

    public function getEventSourceTableGateway()
    {
        
    }
    
    public function getLedgerTransactionTableGateway()
    {
        
    }
    
    /**
     *  Return the Table Gateway for Account Group
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\DB\AccountGroupGateway
     *
    */
    public function getAccountGroupTableGateway()
    {
        return $this['account_group_table_gateway'];
    }
    
     /**
     *  Return the Table Gateway for Accounts
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\DB\AccountGateway
     *
    */
    public function getAccountTableGateway()
    {
        return $this['account_table_gateway'];
    }
    
    public function getAccountEnteriesTableGateway()
    {
        
    }
    
    /**
     *  Return the Account Group Entity Builder
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\DB\AccountGroupBuilder
     *
    */
    public function getAccountGroupEntityBuilder()
    {
        return $this['account_group_entity_builder'];
    }
    
    /**
     *  Return the Account Entity Builder
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\DB\AccountBuilder
     *
    */
    public function getAccountEntityBuilder()
    {
        return $this['account_entity_builder'];
    }
    
    
    //---------------------------------------------------------
    # Internal Dep
    
    public function getAccountsAndGroupInstaller()
    {
        
        
    }
    
    /**
     *  Return the accounts list to install
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\Builder\AccountGroupNode
     *
    */    
    public function getInstalledAccounts()
    {
        return $this['accounts'];
    }
    
    
    
    
    public function getGeneralLedgerAPI()
    {
        
        
    }
    
    
    public function getPostingRulesDispatcher()
    {
        
        
    }
    
    //-------------------------------------------------------
    # Dates and Times
    
    /**
     *  Gets the date the ledger considers now ie
     *  the processing date
     *
     *  @access public
     *  @return DateTime
     *
    */
    public function getProcessingDate()
    {
        return $this['processing_date'];
    }
    
    /**
     *  Sets the date the ledger considers now ie
     *  the processing date
     *
     *  @access public
     *  @return $this
     *  @param DateTime $processing
     *
    */
    public function setProcessingDate(DateTime $processing)
    {
        $this['processing_date'] = $processing;
        
        return $this;
    }
    
    /**
     *  Sets the date the ledger considers occuring date
     *
     *  @access public
     *  @return DateTime
     *
    */
    public function getOccuredDate()
    {
        return $this['occured_date'];
    }
    
    /**
     *  Gets the date the ledger considers the occuring date
     *
     *  @access public
     *  @return $this
     *  @param DateTime $occured
     *
    */
    public function setOccuredDate(DateTime $occured)
    {
        $this['occured_date'] = $occured;
        
        return $this;
    }
    
    
    //---------------------------------------------------------
    # External Dep
    
    
    /**
     *  Return the database layer
     *
     *  @access public
     *  @return Doctrine\DBAL\Connection
     *
    */
    public function getDoctrineDBAL()
    {
        return $this['doctrine_dbal'];
    }
    
    /**
     *  Return the event dispatcher
     *
     *  @access public
     *  @return Symfony\Component\EventDispatcher\EventDispatcherInterface
     *
    */
    public function getEventDispatcher()
    {
        return $this['symfony_eventdispatcher'];
    }
    
    /**
     *  Return the App Logger
     *
     *  @access public
     *  @return Psr\Log\LoggerInterface
     *
    */    
    public function getLogger()
    {
        return $this['psr_log'];       
    }
    
}
/* End of Class */
