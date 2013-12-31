<?php
namespace Migration\Components\Migration\Entities;

use Doctrine\DBAL\Connection,
    Doctrine\DBAL\Schema\AbstractSchemaManager as Schema,
    Doctrine\DBAL\Schema\Schema as ASchema,
    Migration\Components\Migration\EntityInterface;

class init_schema implements EntityInterface
{

    protected function buildVoucherTable(Connection $db, ASchema $sc)
    {
        
        $table = $sc->createTable("ledger_voucher");

        $table->addColumn('voucher_slug','string',array('length'=>150));
        $table->addColumn("voucher_enabled_from", "datetime",array());
        $table->addColumn("voucher_enabled_to", "datetime",array());
        $table->addColumn('voucher_name','string',array('length'=>100));
        $table->addColumn('voucher_description','string',array('length'=>500));
        $table->addColumn('voucher_prefix','string',array('length'=> 20));
        $table->addColumn('voucher_suffix','string',array('length'=>20));
        $table->addColumn('voucher_sequence_strategy','string',array('length'=> 20));
        $table->addColumn('voucher_sequence_no','integer',array('unsiged'=> true));
        
        $table->setPrimaryKey(array('voucher_slug','voucher_enabled_from'));
    }

    
    protected function buildAccountsGroupTable(Connection $db, ASchema $sc)
    {
        # Account Group Table
       
        $accountGroupTable = $sc->createTable("ledger_account_group");
        $accountGroupTable->addColumn("group_id", "integer", array("unsigned" => true));
        $accountGroupTable->addColumn("group_name", "string", array("length" => 150));
        $accountGroupTable->addColumn("group_description", "string", array("length" => 500));
        $accountGroupTable->addColumn("group_date_added", "date",array());
        $accountGroupTable->addColumn("group_date_removed", "date",array());
        $accountGroupTable->addColumn("parent_group_id", "integer", array("unsigned" => true,'notnull'=> false));
        $accountGroupTable->setPrimaryKey(array("group_id"));
        $accountGroupTable->addForeignKeyConstraint($accountGroupTable,array("parent_group_id"), array("group_id"), array("onUpdate" => "CASCADE"));
        
        
    }
    
    protected function buildAccountsTable(Connection $db, ASchema $sc)
    {
        # Account Table
        $accountTable = $sc->createTable("ledger_account");
        $accountTable->addColumn("account_number", "integer", array("unsigned" => true));
        $accountTable->addColumn("account_name","string",array('length' => 50));
        $accountTable->addColumn("account_date_opened", "date",array());
        $accountTable->addColumn("account_date_closed", "date",array());
        $accountTable->addColumn("account_group_id", "integer", array("unsigned" => true));
        $accountTable->setPrimaryKey(array("account_number"));
        $accountTable->addForeignKeyConstraint($sc->getTable('ledger_account_group'), array("account_group_id"), array("group_id"), array("onUpdate" => "CASCADE"));

    }

    
    public function buildSchema(Connection $db, ASchema $schema)
    {
        # Accounts Group Tables
        $this->buildAccountsGroupTable($db,$schema);
        
        # Account Table
        $this->buildAccountsTable($db,$schema);
        
        # Voucher Table
        $this->buildVoucherTable($db,$schema);
        
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
