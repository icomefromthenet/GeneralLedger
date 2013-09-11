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
    
    public function boot(DateTime $now)
    {
        
        $this['now'] = $now;
        
        
        
        
        $this['account_group_entity_builder'] = $this->share(function($c){
            return new \IComeFromTheNet\Ledger\DB\AccountGroupBuilder();    
        });
        

        
        $this['account_group_table_gateway'] = $this->share(function($c) {
                return new \IComeFromTheNet\Ledger\DB\AccountGroupGateway('ledger_account_group',
                                                                          $c->getDoctrineDBAL(),
                                                                          $c->getEventDispatcher(),
                                                                          $c->getAccountGroupDBMeta(),
                                                                          null,
                                                                          $c->getAccountGroupEntityBuilder()
                                                                          );
        });  
        
        
        $this['account_group_db_meta'] = $this->share(function($c) {
            $table = new \Doctrine\DBAL\Schema\Table('ledger_account_group');
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
    
    /**
     *  Return the metadata for Account Group Table
     *
     *  @access public
     *  @return \Doctrine\DBAL\Schema\Table
     *
    */
    public function getAccountGroupDBMeta()
    {
        return $this['account_group_db_meta'];
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
        return['accounts'];
    }
    
    
    
    
    public function getGeneralLedgerAPI()
    {
        
        
    }
    
    
    public function getPostingRulesDispatcher()
    {
        
        
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
