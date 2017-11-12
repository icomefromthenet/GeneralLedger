<?php
namespace Migration\Components\Migration\Entities;

use Doctrine\DBAL\Connection,
    Doctrine\DBAL\Schema\AbstractSchemaManager as Schema,
    Doctrine\DBAL\Schema\Schema as ASchema,
    Migration\Components\Migration\EntityInterface;

class init_schema implements EntityInterface
{

    
    public function buildSchema(Connection $db, ASchema $schema)
    {
        # Account Group Table
        $accountGroupTable = $schema->createTable("ledger_account_group");
        $accountGroupTable->addColumn("child_account_id", "integer", array("unsigned" => true));
        $accountGroupTable->addColumn("parent_account_id", "integer", array("unsigned" => true,'notnull'=> false));
        
        $accountGroupTable->setPrimaryKey(array("child_account_id","parent_account_id"));
        $accountGroupTable->addForeignKeyConstraint('ledger_account',array("parent_account_id"), array("account_id"), array("onUpdate" => "CASCADE"));
        $accountGroupTable->addForeignKeyConstraint('ledger_account',array("child_account_id"), array("account_id"), array("onUpdate" => "CASCADE"));
        
        # Account Table
        $accountTable = $schema->createTable("ledger_account");
        $accountTable->addColumn("account_id", "integer", array("unsigned" => true,"autoincrement"=>true));
        $accountTable->addColumn("account_number", "string", array("length" => 25));
        $accountTable->addColumn("account_name","string",array('length' => 50));
        $accountTable->addColumn("account_name_slug","string",array('length' => 50));
        $accountTable->addColumn('hide_ui',"boolean",array("default" => false));
        $accountTable->addColumn("is_left", "boolean", array('notnull'=> true));
        $accountTable->addColumn("is_right", "boolean", array('notnull'=> true));

        $accountTable->setPrimaryKey(array("account_id"));
        $accountTable->addUniqueIndex(array("account_number"));


        # Org Unit
        $orgTable = $schema->createTable("ledger_org_unit");
        $orgTable->addColumn('org_unit_id',"integer",array("unsigned" => true, "autoincrement" => true));
        $orgTable->addColumn('org_unit_name',"string",array("length" => 50));
        $orgTable->addColumn('org_unit_name_slug',"string",array("length" => 50));
        $orgTable->addColumn('hide_ui',"boolean",array("default" => false));
        
        $orgTable->setPrimaryKey(array("org_unit_id"));
    
        # Ledger Users
        $userTable = $schema->createTable("ledger_user");
        $userTable->addColumn('user_id',"integer",array("unsigned" => true, "autoincrement" => true));
        $userTable->addColumn('external_guid',"guid",array());
        $userTable->addColumn('rego_date','datetime',array('notnull' => true));
       
        $userTable->setPrimaryKey(array("user_id"));
    
        
        # Transaction Source
        $journalTable = $schema->createTable("ledger_journal_type");
        $journalTable->addColumn('journal_type_id',"integer",array("unsigned" => true, "autoincrement" => true));
        $journalTable->addColumn('journal_name',"string",array("length" => 50));
        $journalTable->addColumn('journal_name_slug',"string",array("length" => 50));
        $journalTable->addColumn('hide_ui',"boolean",array("default" => false));
        
        $journalTable->setPrimaryKey(array("journal_type_id"));
        
        
        # Transaction Header Table
        $transactionTable = $schema->createTable("ledger_transaction");
        $transactionTable->addColumn('transaction_id',"integer",array("unsigned" => true, "autoincrement" => true));
        $transactionTable->addColumn('org_unit_id',"integer",array("notnull" => false,"unsigned" => true));
        $transactionTable->addColumn('process_dt',"date",array("notnull" => true));
        $transactionTable->addColumn('occured_dt',"date",array("notnull" => true));
        $transactionTable->addColumn('vouchernum',"string",array("length" => 100));
        $transactionTable->addColumn('journal_type_id',"integer",array("notnull"=> true,"unsigned" => true));
        $transactionTable->addColumn('adjustment_id',"integer",array("notnull"=> false,"unsigned" => true));
        $transactionTable->addColumn('user_id',"integer",array("notnull"=> false,"unsigned" => true));
        
        
        $transactionTable->setPrimaryKey(array("transaction_id"));
        $transactionTable->addForeignKeyConstraint('ledger_journal_type', array("journal_type_id"), array("journal_type_id"));
        $transactionTable->addForeignKeyConstraint('ledger_transaction',array("adjustment_id"),array("transaction_id"));
        $transactionTable->addForeignKeyConstraint('ledger_org_unit', array("org_unit_id"), array("org_unit_id"));
        $transactionTable->addForeignKeyConstraint('ledger_user', array("user_id"), array("user_id"));
        
    
        # Account Movements
        $entryTable = $schema->createTable('ledger_entry');
        $entryTable->addColumn('entry_id',"integer",array("unsigned" => true, "autoincrement" => true)); 
        $entryTable->addColumn('transaction_id',"integer",array("notnull" => true,"unsigned" => true));
        $entryTable->addColumn('account_id',"integer",array("notnull" => true,"unsigned" => true));
        $entryTable->addColumn('movement',"float",array("notnull" => true));
        
        $entryTable->setPrimaryKey(array("entry_id"));
        $entryTable->addForeignKeyConstraint('ledger_transaction', array("transaction_id"), array("transaction_id"));
        $entryTable->addForeignKeyConstraint('ledger_account', array("account_id"), array("account_id"));
    
        # Agg table Value Table
        $dailyTable = $schema->createTable('ledger_daily');
        $dailyTable->addColumn('process_dt',"date",array("notnull" => true));
        $dailyTable->addColumn('account_id',"integer",array("notnull" => true,"unsigned" => true));
        $dailyTable->addColumn('balance',"float",array("notnull" => true));
        
        $dailyTable->setPrimaryKey(array("process_dt","account_id"));
        $dailyTable->addForeignKeyConstraint('ledger_account', array("account_id"), array("account_id"));
        


        $orgAggTable = $schema->createTable('ledger_daily_org');
        $orgAggTable->addColumn('org_unit_id',"integer",array("notnull" => true,"unsigned" => true));
        $orgAggTable->addColumn('process_dt',"date",array("notnull" => true));
        $orgAggTable->addColumn('account_id',"integer",array("notnull" => true,"unsigned" => true));
        $orgAggTable->addColumn('balance',"float",array("notnull" => true));
      
        $orgAggTable->setPrimaryKey(array("process_dt","account_id","org_unit_id"));
        $orgAggTable->addForeignKeyConstraint('ledger_account', array("account_id"), array("account_id"));
        $orgAggTable->addForeignKeyConstraint('ledger_org_unit', array("org_unit_id"), array("org_unit_id"));
        

        $userAggTable = $schema->createTable('ledger_daily_user');
        $userAggTable->addColumn('user_id',"integer",array("notnull" => true,"unsigned" => true));
        $userAggTable->addColumn('process_dt',"date",array("notnull" => true));
        $userAggTable->addColumn('account_id',"integer",array("notnull" => true,"unsigned" => true));
        $userAggTable->addColumn('balance',"float",array("notnull" => true));

        $userAggTable->setPrimaryKey(array("process_dt","account_id","user_id"));
        $userAggTable->addForeignKeyConstraint('ledger_account', array("account_id"), array("account_id"));
        $userAggTable->addForeignKeyConstraint('ledger_user', array("user_id"), array("user_id"));

        
        return $schema;
    }
    
    public function up(Connection $db, Schema $sc)
    {
        
        
        $schema = $this->buildSchema($db,new ASchema());
        
        $queries = $schema->toSql($db->getDatabasePlatform()); // get queries to create this schema.
        
        # execute setup queries
        foreach($queries as $query) {
            
            echo $query . PHP_EOL;
            $db->exec($query);    
        }
        
       
        
    }

    public function down(Connection $db, Schema $sc)
    {


    }


}
/* End of File */
