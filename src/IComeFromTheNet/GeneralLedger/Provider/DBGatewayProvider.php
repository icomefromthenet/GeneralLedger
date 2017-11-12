<?php 
namespace IComeFromTheNet\GeneralLedger\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Doctrine\DBAL\Schema\Schema;
use DBALGateway\Table\GatewayProxyCollection;
use IComeFromTheNet\GeneralLedger\Entity\CommonBuilder;
use IComeFromTheNet\GeneralLedger\Gateway\CommonGateway;
use IComeFromTheNet\GeneralLedger\Gateway\CommonQuery;

/**
 * Will bootstrap the db schema
 * 
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class DBGatewayProvider implements ServiceProviderInterface
{
    
     
     protected $aDefaultTableMap;
     
     protected $oGatewayProxyCollection;
     
     protected $oSchema;
     
     
     
     public function __construct(array $aDefaultTableMap, Schema $oSchema,  GatewayProxyCollection $oGatewayProxyCollection)
     {
         $this->aDefaultTableMap          = $aDefaultTableMap;
         $this->oGatewayProxyCollection   = $oGatewayProxyCollection;
         $this->oSchema                   = $oSchema;
         
     }
     
     
     public function register(Container $pimple, array $values = [])
     {
       
        $c                  = $pimple;
        $oGatewayCol        = $this->oGatewayProxyCollection;
        $aDefaultTableMap   = $this->aDefaultTableMap;
        $oSchema            = $this->oSchema;
         
        $aTableMap          = $aDefaultTableMap;
        
        
        
        $c['ledger_table_account'] = function($c) use($aTableMap, $oSchema) {
             $sActualTableName = $aTableMap['ledger_account'];
             
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
 
            return $table;
        };
        
        $c['ledger_table_group'] = function($c) use ($aTableMap, $oSchema) {
            $sActualTableName = $aTableMap['ledger_account_group'];
            
            # Systems Table
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn("child_account_id", "integer", array("unsigned" => true));
            $table->addColumn("parent_account_id", "integer", array("unsigned" => true,'notnull'=> false));
            
            $table->setPrimaryKey(array("child_account_id","parent_account_id"));
            $table->addForeignKeyConstraint($aTableMap['ledger_account'],array("parent_account_id"), array("account_id"), array("onUpdate" => "CASCADE"));
            $table->addForeignKeyConstraint($aTableMap['ledger_account'],array("child_account_id"), array("account_id"), array("onUpdate" => "CASCADE"));

            
            return $table;
        };
        
        
        $c['ledger_table_org'] = function($c) use ($aTableMap, $oSchema) {
            
            $sActualTableName = $aTableMap['ledger_org_unit'];
            
            # Systems Table
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn('org_unit_id',"integer",array("unsigned" => true, "autoincrement" => true));
            $table->addColumn('org_unit_name',"string",array("length" => 50));
            $table->addColumn('org_unit_name_slug',"string",array("length" => 50));
            $table->addColumn('hide_ui',"boolean",array("default" => false));
            
            $table->setPrimaryKey(array("org_unit_id"));
        
        
            return $table;
            
        };
        
        $c['ledger_table_user'] = function($c) use ($aTableMap, $oSchema) {
            $sActualTableName = $aTableMap['ledger_user'];
            
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn('user_id',"integer",array("unsigned" => true, "autoincrement" => true));
            $table->addColumn('external_guid',"guid",array());
            $table->addColumn('rego_date','datetime',array('notnull' => true));
            
            $table->setPrimaryKey(array("user_id"));
         
            return $table;    
        };
        
        $c['ledger_table_journal'] = function($c) use ($aTableMap, $oSchema) {
            $sActualTableName = $aTableMap['ledger_journal_type'];
            
            # Systems Table
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn('journal_type_id',"integer",array("unsigned" => true, "autoincrement" => true));
            $table->addColumn('journal_name',"string",array("length" => 50));
            $table->addColumn('journal_name_slug',"string",array("length" => 50));
            $table->addColumn('hide_ui',"boolean",array("default" => false));
            
            $table->setPrimaryKey(array("journal_type_id"));
        
            return $table;    
        };
        
        
        $c['ledger_table_transaction'] = function($c) use ($aTableMap, $oSchema) {
            
            $sActualTableName = $aTableMap['ledger_transaction'];
            
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

            
            return $table;
        };
        
        
        $c['ledger_table_entry'] = function($c) use ($aTableMap, $oSchema) {
            $sActualTableName = $aTableMap['ledger_entry'];
            
            # Systems Table
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn('entry_id',"integer",array("unsigned" => true, "autoincrement" => true)); 
            $table->addColumn('transaction_id',"integer",array("notnull" => true,"unsigned" => true));
            $table->addColumn('account_id',"integer",array("notnull" => true,"unsigned" => true));
            $table->addColumn('movement',"float",array("notnull" => true));
            
            $table->setPrimaryKey(array("entry_id"));
            $table->addForeignKeyConstraint($aTableMap['ledger_transaction'], array("transaction_id"), array("transaction_id"));
            $table->addForeignKeyConstraint($aTableMap['ledger_account'], array("account_id"), array("account_id"));

            return $table;
            
        };
        
        
        $c['ledger_table_agg_daily'] = function($c) use ($aTableMap, $oSchema) {
            $sActualTableName = $aTableMap['ledger_daily'];
            
            # Systems Table
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn('process_dt',"date",array("notnull" => true));
            $table->addColumn('account_id',"integer",array("notnull" => true,"unsigned" => true));
            $table->addColumn('balance',"float",array("notnull" => true));
            
            $table->setPrimaryKey(array("process_dt","account_id"));
            $table->addForeignKeyConstraint($aTableMap['ledger_account'], array("account_id"), array("account_id"));

            return $table;
        };
        
        $c['ledger_table_agg_user'] = function($c) use ($aTableMap, $oSchema) {
            $sActualTableName = $aTableMap['ledger_daily_user'];
            
            # Systems Table
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn('user_id',"integer",array("notnull" => true,"unsigned" => true));
            $table->addColumn('process_dt',"date",array("notnull" => true));
            $table->addColumn('account_id',"integer",array("notnull" => true,"unsigned" => true));
            $table->addColumn('balance',"float",array("notnull" => true));
            
            $table->setPrimaryKey(array("process_dt","account_id","user_id"));
            $table->addForeignKeyConstraint($aTableMap['ledger_account'], array("account_id"), array("account_id"));
            $table->addForeignKeyConstraint($aTableMap['ledger_user'], array("user_id"), array("user_id"));
            
            return $table;
            
        };
        
        $c['ledger_table_agg_org'] = function($c) use ($aTableMap, $oSchema) {
            $sActualTableName = $aTableMap['ledger_daily_org'];
            
            # Systems Table
            $table = $oSchema->createTable($sActualTableName);
            $table->addColumn('org_unit_id',"integer",array("notnull" => true,"unsigned" => true));
            $table->addColumn('process_dt',"date",array("notnull" => true));
            $table->addColumn('account_id',"integer",array("notnull" => true,"unsigned" => true));
            $table->addColumn('balance',"float",array("notnull" => true));
            
            $table->setPrimaryKey(array("process_dt","account_id","org_unit_id"));
            $table->addForeignKeyConstraint($aTableMap['ledger_account'], array("account_id"), array("account_id"));
            $table->addForeignKeyConstraint($aTableMap['ledger_org_unit'], array("org_unit_id"), array("org_unit_id"));

            return $table;
        };
        
        $oGatewayCol->addGateway('ledger_account',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['ledger_account'];
            $table            = $c['ledger_table_account'];
          
          
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdapter();
            $oGatewayCol      = $c->getGatewayCollection();
            
            # Systems Table
         
           
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
            $oDatabase        = $c->getDatabaseAdapter();
            $oGatewayCol      = $c->getGatewayCollection();
            
            $table            = $c['ledger_table_group'];
          
            $oGateway = new CommonGateway($sActualTableName, $oDatabase, $oEvent, $table , null, null);

            $oGateway->setTableQueryAlias('acc');
            $oGateway->setGatewayCollection($oGatewayCol);
            
            return $oGateway;
        });
        
        $oGatewayCol->addGateway('ledger_org_unit',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['ledger_org_unit'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdapter();
            $oGatewayCol      = $c->getGatewayCollection();
            

            $table            = $c['ledger_table_org'];

            $oBuilder = new CommonBuilder(CommonBuilder::MODE_ORGUNIT);
            $oGateway = new CommonGateway($sActualTableName, $oDatabase, $oEvent, $table , null, $oBuilder);
    
            $oBuilder->setGateway($oGateway);
            $oBuilder->setLogger($oLogger);

            $oGateway->setTableQueryAlias('lou');
            $oGateway->setGatewayCollection($oGatewayCol);
            
            return $oGateway;
        });
        
        $oGatewayCol->addGateway('ledger_user',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['ledger_user'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdapter();
            $oGatewayCol      = $c->getGatewayCollection();
            
            $table            = $c['ledger_table_user'];       
            
            $oBuilder = new CommonBuilder(CommonBuilder::MODE_USER);    
            $oGateway = new CommonGateway($sActualTableName, $oDatabase, $oEvent, $table , null, $oBuilder);
    
            $oBuilder->setGateway($oGateway);
            $oBuilder->setLogger($oLogger);

            $oGateway->setTableQueryAlias('lu');
            $oGateway->setGatewayCollection($oGatewayCol);
            
            return $oGateway;
        });
        
        $oGatewayCol->addGateway('ledger_journal_type',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['ledger_journal_type'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdapter();
            $oGatewayCol      = $c->getGatewayCollection();
            
            $table            = $c['ledger_table_journal'];    
        
            $oBuilder = new CommonBuilder(CommonBuilder::MODE_JTYPE);
            $oGateway = new CommonGateway($sActualTableName, $oDatabase, $oEvent, $table , null, $oBuilder);
    
            $oBuilder->setGateway($oGateway);
            $oBuilder->setLogger($oLogger);

            $oGateway->setTableQueryAlias('ljt');
            $oGateway->setGatewayCollection($oGatewayCol);
            
            return $oGateway;
        });
        
        $oGatewayCol->addGateway('ledger_transaction',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['ledger_transaction'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdapter();
            $oGatewayCol      = $c->getGatewayCollection();
     
            $table            = $c['ledger_table_transaction'];
            
     
            $oBuilder = new CommonBuilder(CommonBuilder::MODE_TRANSACTION);    
            $oGateway = new CommonGateway($sActualTableName, $oDatabase, $oEvent, $table , null, $oBuilder);
    
            $oBuilder->setGateway($oGateway);
            $oBuilder->setLogger($oLogger);

    
            $oGateway->setTableQueryAlias('lt');
            $oGateway->setGatewayCollection($oGatewayCol);
            
            return $oGateway;
        });
        
        $oGatewayCol->addGateway('ledger_entry',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['ledger_entry'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdapter();
            $oGatewayCol      = $c->getGatewayCollection();
            
            $table            = $c['ledger_table_entry'];
       
            $oBuilder = new CommonBuilder(CommonBuilder::MODE_ENTRY);
            $oGateway = new CommonGateway($sActualTableName, $oDatabase, $oEvent, $table , null, $oBuilder);
    
            $oBuilder->setGateway($oGateway);
            $oBuilder->setLogger($oLogger);

    
            $oGateway->setTableQueryAlias('le');
            $oGateway->setGatewayCollection($oGatewayCol);
            
            return $oGateway;
        });
        
        $oGatewayCol->addGateway('ledger_daily',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['ledger_daily'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdapter();
            $oGatewayCol      = $c->getGatewayCollection();
            
            $table            = $c['ledger_table_agg_daily'];        
    
            $oBuilder = new CommonBuilder(CommonBuilder::MODE_AGG_ENTRY);
            $oGateway = new CommonGateway($sActualTableName, $oDatabase, $oEvent, $table , null, $oBuilder);
    
            $oBuilder->setGateway($oGateway);
            $oBuilder->setLogger($oLogger);

    
            $oGateway->setTableQueryAlias('la');
            $oGateway->setGatewayCollection($oGatewayCol);
            
            return $oGateway;
        });
        
        $oGatewayCol->addGateway('ledger_daily_user',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['ledger_daily_user'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdapter();
            $oGatewayCol      = $c->getGatewayCollection();
            
            $table            = $c['ledger_table_agg_user'];   
         
            $oBuilder = new CommonBuilder(CommonBuilder::MODE_AGG_USER);
            $oGateway = new CommonGateway($sActualTableName, $oDatabase, $oEvent, $table , null, $oBuilder);
    
            $oBuilder->setGateway($oGateway);
            $oBuilder->setLogger($oLogger);

    
            $oGateway->setTableQueryAlias('lau');
            $oGateway->setGatewayCollection($oGatewayCol);
            
            return $oGateway;
        });
        
        $oGatewayCol->addGateway('ledger_daily_org',function() use ($c, $oSchema, $aTableMap) {
            $sActualTableName = $aTableMap['ledger_daily_org'];
            $oEvent           = $c->getEventDispatcher();
            $oLogger          = $c->getAppLogger();
            $oDatabase        = $c->getDatabaseAdapter();
            $oGatewayCol      = $c->getGatewayCollection();
            
            $table            = $c['ledger_table_agg_org'];   
         
            $oBuilder = new CommonBuilder(CommonBuilder::MODE_AGG_ORG);
            $oGateway = new CommonGateway($sActualTableName, $oDatabase, $oEvent, $table , null, $oBuilder);
    
    
            $oBuilder->setGateway($oGateway);
            $oBuilder->setLogger($oLogger);

            $oGateway->setTableQueryAlias('lao');
            $oGateway->setGatewayCollection($oGatewayCol);
            
            return $oGateway;
        });
     
     }
     
     
    public function boot(Container $pimple)
    {
       
    }
    
    
}
/* End of Class */