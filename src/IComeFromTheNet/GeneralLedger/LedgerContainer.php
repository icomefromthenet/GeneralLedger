<?php
namespace IComeFromTheNet\GeneralLedger;

use DateTime;
use Pimple;
use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use DBALGateway\Table\GatewayProxyCollection;
use DBALGateway\Metadata\Schema;

use IComeFromTheNet\GeneralLedger\Exception\LedgerException;
use IComeFromTheNet\GeneralLedger\Entity\CommonBuilder;
use IComeFromTheNet\GeneralLedger\Gateway\CommonGateway;



class LedgerContainer extends Pimple
{
    
    /**
     * Class constructor
     * 
     * @param Symfony\Component\EventDispatcher\EventDispatcherInterface
     * @param Doctrine\DBAL\Connection $oAdapter
     * @param Psr\Log\LoggerInterface $oLogger
     */
    public function __construct(EventDispatcherInterface $oDispatcher, Connection $oAdapter, LoggerInterface $oLogger)
    {
        $this['database'] = $oAdapter;
        $this['logger'] = $oLogger;
        $this['event'] = $oDispatcher;
    }
    
    
    /**
     * Returns the database adapter
     * 
     * @return Doctrine\DBAL\Connection
     */ 
    public function getDatabaseAdaper()
    {
        return $this['database'];
    }
    
    
    
    /**
     * Returns the Applogger
     * 
     * @return Psr\Log\LoggerInterface
     */ 
    public function getAppLogger()
    {
        return $this['logger'];
    }
    
    /**
     * Returns the event dispatcher
     * 
     * @return Symfony\Component\EventDispatcher\EventDispatcherInterface
     */ 
    public function getEventDispatcher()
    {
        return $this['event'];
    }
    
    /**
     * Return the Gateway Collection
     * 
     * @return DBALGateway\Table\GatewayProxyCollection
     */ 
    public function getGatewayCollection()
    {
        return $this['gateway_collection'];
    }
    
    
    
    /**
     * Return the map of internal table names
     * to actual table names
     *  
     * @return array[internal => actual]
     */ 
    public function getTableMap()
    {
        return $this['table_map'];
    }
    
    
    
    public function boot(DateTime $oProcessingDate, $aTableMap = null)
    {
        $this['processing_date'] = $oProcessingDate;
        
        if(null === $aTableMap) {
            $aTableMap = array(
             # Accounts
              'ledger_account_group' => 'ledger_account_group'
             ,'ledger_account'       => 'ledger_account'
             
             # Journal / Org Units / Users
             ,'ledger_org_unit'      => 'ledger_org_unit'
             ,'ledger_journal_type'  => 'ledger_journal_type'
             ,'ledger_user'          => 'ledger_user'
             
             # Transaction table
             ,'ledger_transaction'   => 'ledger_transaction'
             ,'ledger_entry'         => 'ledger_entry'
             ,'ledger_daily'         => 'ledger_daily'
             ,'ledger_daily_org'     => 'ledger_daily_org'
             ,'ledger_daily_user'    => 'ledger_daily_user'
             
             
            );
        }
        $this['table_map']       = $aTableMap;
        
        #
        # Boostrap the table Gateways
        #
        $c           = $this;
        $oSchema     = new Schema();
        $oGatewayCol = new GatewayProxyCollection($oSchema);
        
        $this['gateway_collection'] = $oGatewayCol;    
        
        $oGatewayCol->addGateway('ledger_account',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['ledger_account'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdaper();
            $oGatewayCol      = $c->getGatewayCollection();
            
            # Systems Table
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn("account_id", "integer", array("unsigned" => true,"autoincrement"=>true));
            $table->addColumn("account_number", "string", array("length" => 25));
            $table->addColumn("account_name","string",array('length' => 50));
            $table->addColumn("account_name_slug","string",array('length' => 50));
            $table->addColumn('hide_ui',"boolean",array("default" => false));
            $table->addColumn("is_left", "boolean", array('notnull'=> true));
            $table->addColumn("is_right", "boolean", array('notnull'=> true));

            $table->setPrimaryKey(array("account_id"));
            $table->addUniqueIndex(array("account_number"));

           
            $oBuilder = new CommonBuilder(CommonBuilder::MODE_ACCOUNT);
            $oGateway = new CommonGateway($sActualTableName, $oDatabase, $oEvent, $table , null, $oBuilder);
    
            $oBuilder->setGateway($oGateway);
            $oBuilder->setLogger($oLogger);
            $oGateway->setTableQueryAlias('acc');
            $oGateway->setGatewayCollection($oGatewayCol);
            
            return $oGateway;
        });
        
        $oGatewayCol->addGateway('ledger_account_group',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['ledger_account_group'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdaper();
            $oGatewayCol      = $c->getGatewayCollection();
            
            # Systems Table
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn("child_account_id", "integer", array("unsigned" => true));
            $table->addColumn("parent_account_id", "integer", array("unsigned" => true,'notnull'=> false));
            
            $table->setPrimaryKey(array("child_account_id","parent_account_id"));
            $table->addForeignKeyConstraint($aTableMap['ledger_account'],array("parent_account_id"), array("account_id"), array("onUpdate" => "CASCADE"));
            $table->addForeignKeyConstraint($aTableMap['ledger_account'],array("child_account_id"), array("account_id"), array("onUpdate" => "CASCADE"));

            $oGateway = new CommonGateway($sActualTableName, $oDatabase, $oEvent, $table , null, null);
    
            $oGateway->setTableQueryAlias('acc');
            $oGateway->setGatewayCollection($oGatewayCol);
            
            return $oGateway;
        });
        
        $oGatewayCol->addGateway('ledger_org_unit',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['ledger_org_unit'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdaper();
            $oGatewayCol      = $c->getGatewayCollection();
            
            # Systems Table
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn('org_unit_id',"integer",array("unsigned" => true, "autoincrement" => true));
            $table->addColumn('org_unit_name',"string",array("length" => 50));
            $table->addColumn('org_unit_name_slug',"string",array("length" => 50));
            $table->addColumn('account_name',"boolean",array("default" => false));
            
            $table->setPrimaryKey(array("org_unit_id"));
    
            $oGateway = new CommonGateway($sActualTableName, $oDatabase, $oEvent, $table , null, null);
    
            $oGateway->setTableQueryAlias('lou');
            $oGateway->setGatewayCollection($oGatewayCol);
            
            return $oGateway;
        });
        
        $oGatewayCol->addGateway('ledger_user',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['ledger_user'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdaper();
            $oGatewayCol      = $c->getGatewayCollection();
            
            # Systems Table
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn('user_id',"integer",array("unsigned" => true, "autoincrement" => true));
            $table->addColumn('external_guid',"guid",array());
            $table->addColumn('rego_date','datetime',array('notnull' => true));
            
            $table->setPrimaryKey(array("user_id"));
    
            $oGateway = new CommonGateway($sActualTableName, $oDatabase, $oEvent, $table , null, null);
    
            $oGateway->setTableQueryAlias('lu');
            $oGateway->setGatewayCollection($oGatewayCol);
            
            return $oGateway;
        });
        
        $oGatewayCol->addGateway('ledger_journal_type',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['ledger_journal_type'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdaper();
            $oGatewayCol      = $c->getGatewayCollection();
            
            # Systems Table
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn('journal_type_id',"integer",array("unsigned" => true, "autoincrement" => true));
            $table->addColumn('journal_name',"string",array("length" => 50));
            $table->addColumn('journal_name_slug',"string",array("length" => 50));
            $table->addColumn('hide_ui',"boolean",array("default" => false));
            
            $table->setPrimaryKey(array("journal_type_id"));
        
            $oGateway = new CommonGateway($sActualTableName, $oDatabase, $oEvent, $table , null, null);
    
            $oGateway->setTableQueryAlias('ljt');
            $oGateway->setGatewayCollection($oGatewayCol);
            
            return $oGateway;
        });
        
        $oGatewayCol->addGateway('ledger_transaction',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['ledger_transaction'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdaper();
            $oGatewayCol      = $c->getGatewayCollection();
            
            # Systems Table
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn('transaction_id',"integer",array("unsigned" => true, "autoincrement" => true));
            $table->addColumn('org_unit_id',"integer",array("notnull" => false,"unsigned" => true));
            $table->addColumn('process_dt',"datetime",array("notnull" => true));
            $table->addColumn('occured_dt',"date",array("notnull" => true));
            $table->addColumn('vouchernum',"string",array("length" => 100));
            $table->addColumn('journal_type_id',"integer",array("notnull"=> true,"unsigned" => true));
            $table->addColumn('adjustment_id',"integer",array("notnull"=> false,"unsigned" => true));
            $table->addColumn('user_id',"integer",array("notnull"=> false,"unsigned" => true));
            
            
            $table->setPrimaryKey(array("transaction_id"));
            $table->addForeignKeyConstraint($aTableMap['ledger_journal_type'], array("journal_type_id"), array("journal_type_id"));
            $table->addForeignKeyConstraint($aTableMap['ledger_transaction'],array("adjustment_id"),array("transaction_id"));
            $table->addForeignKeyConstraint($aTableMap['ledger_org_unit'], array("org_unit_id"), array("org_unit_id"));
            $table->addForeignKeyConstraint($aTableMap['ledger_user'], array("user_id"), array("user_id"));

    
            $oGateway = new CommonGateway($sActualTableName, $oDatabase, $oEvent, $table , null, null);
    
            $oGateway->setTableQueryAlias('lt');
            $oGateway->setGatewayCollection($oGatewayCol);
            
            return $oGateway;
        });
        
        $oGatewayCol->addGateway('ledger_entry',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['ledger_entry'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdaper();
            $oGatewayCol      = $c->getGatewayCollection();
            
            # Systems Table
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn('entry_id',"integer",array("unsigned" => true, "autoincrement" => true)); 
            $table->addColumn('transaction_id',"integer",array("notnull" => true,"unsigned" => true));
            $table->addColumn('account_id',"integer",array("notnull" => true,"unsigned" => true));
            $table->addColumn('movement',"float",array("notnull" => true));
            
            $table->setPrimaryKey(array("entry_id"));
            $table->addForeignKeyConstraint($aTableMap['ledger_transaction'], array("transaction_id"), array("transaction_id"));
            $table->addForeignKeyConstraint($aTableMap['ledger_account'], array("account_id"), array("account_id"));

    
            $oGateway = new CommonGateway($sActualTableName, $oDatabase, $oEvent, $table , null, null);
    
            $oGateway->setTableQueryAlias('le');
            $oGateway->setGatewayCollection($oGatewayCol);
            
            return $oGateway;
        });
        
        $oGatewayCol->addGateway('ledger_daily',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['ledger_daily'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdaper();
            $oGatewayCol      = $c->getGatewayCollection();
            
            # Systems Table
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn('process_dt',"integer",array("notnull" => true));
            $table->addColumn('account_id',"integer",array("notnull" => true,"unsigned" => true));
            $table->addColumn('balance',"float",array("notnull" => true));
            
            $table->setPrimaryKey(array("process_dt","account_id"));
            $table->addForeignKeyConstraint($aTableMap['ledger_account'], array("account_id"), array("account_id"));

    
            $oGateway = new CommonGateway($sActualTableName, $oDatabase, $oEvent, $table , null, null);
    
            $oGateway->setTableQueryAlias('la');
            $oGateway->setGatewayCollection($oGatewayCol);
            
            return $oGateway;
        });
        
        
         $oGatewayCol->addGateway('ledger_daily_user',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['ledger_daily_user'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdaper();
            $oGatewayCol      = $c->getGatewayCollection();
            
            # Systems Table
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn('user_id',"integer",array("notnull" => true,"unsigned" => true));
            $table->addColumn('process_dt',"integer",array("notnull" => true));
            $table->addColumn('account_id',"integer",array("notnull" => true,"unsigned" => true));
            $table->addColumn('balance',"float",array("notnull" => true));
            
            $table->setPrimaryKey(array("process_dt","account_id"));
            $table->addForeignKeyConstraint($aTableMap['ledger_account'], array("account_id"), array("account_id"));
            $table->addForeignKeyConstraint($aTableMap['ledger_user'], array("user_id"), array("user_id"));

    
            $oGateway = new CommonGateway($sActualTableName, $oDatabase, $oEvent, $table , null, null);
    
            $oGateway->setTableQueryAlias('lau');
            $oGateway->setGatewayCollection($oGatewayCol);
            
            return $oGateway;
        });
        
         $oGatewayCol->addGateway('ledger_daily_org',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['ledger_daily_org'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdaper();
            $oGatewayCol      = $c->getGatewayCollection();
            
            # Systems Table
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn('org_unit_id',"integer",array("notnull" => true,"unsigned" => true));
            $table->addColumn('process_dt',"integer",array("notnull" => true));
            $table->addColumn('account_id',"integer",array("notnull" => true,"unsigned" => true));
            $table->addColumn('balance',"float",array("notnull" => true));
            
            $table->setPrimaryKey(array("process_dt","account_id"));
            $table->addForeignKeyConstraint($aTableMap['ledger_account'], array("account_id"), array("account_id"));
            $table->addForeignKeyConstraint($aTableMap['ledger_org_unit'], array("org_unit_id"), array("org_unit_id"));

    
            $oGateway = new CommonGateway($sActualTableName, $oDatabase, $oEvent, $table , null, null);
    
            $oGateway->setTableQueryAlias('lao');
            $oGateway->setGatewayCollection($oGatewayCol);
            
            return $oGateway;
        });
        
        
    }
    
}
/* End of Class */