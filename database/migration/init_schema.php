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
        # Voucher Groups
        $table = $sc->createTable("ledger_voucher_group");
        $table->addColumn('voucher_group_id','integer',array("unsigned" => true));
        $table->addColumn('voucher_group_name','string',array("length" => 100));
        $table->addColumn('is_disabled','boolean',array("default"=>false));
        $table->addColumn('sort_order','integer',array("unsigned" => true));
        $table->addColumn('date_created','datatime',array());
        
        $table->setPrimaryKey(array('voucher_group_id'));
        $table->addUniqueIndex(array('voucher_group_name'),'gl_voucher_group_uiq1');
        
        
        # Voucher Rules
        $table = $sc->createTable("ledger_voucher_gen_rule");
        $table->addColumn('voucher_rule_name','string',array('length'=> 25));
        $table->addColumn('voucher_gen_rule_id','integer',array('unsiged'=> true));
        $table->addColumn('voucher_sequence_padding_char','string',array('legnth'=>'1'));
        $table->addColumn('voucher_prefix','string',array('length'=> 20));
        $table->addColumn('voucher_suffix','string',array('length'=>20));
        $table->addColumn('voucher_maxlength','integer',array('unsiged'=> true));
        
        
        # Voucher Type Table
        $table = $sc->createTable("ledger_voucher_type");
        $table->addColumn('voucher_id','integer',array("unsigned" => true));
        $table->addColumn("voucher_enabled_from", "datetime",array());
        $table->addColumn("voucher_enabled_to", "datetime",array());
        $table->addColumn('voucher_name','string',array('length'=>100));
        $table->addColumn('voucher_description','string',array('length'=>500));
        $table->addColumn('voucher_formatter','string',array('length'=> 100));
        $table->addColumn('voucher_sequence_strategy','string',array('length'=> 20));
        $table->addColumn('voucher_sequence_no','integer',array('unsiged'=> true));
        $table->addColumn('voucher_group_id','integer',array('unsiged'=> true));
        $table->addColumn('voucher_gen_rule_id','integer',array('unsiged'=> true));
        
        
        $table->setPrimaryKey(array('voucher_id'));
        $table->addUniqueIndex(array('vouch_name'),'gl_voucher_type_uiq1');
        $table->addForeignKeyConstraint('ledger_voucher_group',array('voucher_group_id'),array('voucher_group_id'),'gl_voucher_type_fk1');
        $table->addForeignKeyConstraint('ledger_voucher_gen_rule',array('voucher_gen_rule_id'),array('voucher_gen_rule_id'),'gl_voucher_type_fk2');
        
        
        # Vouchers Table (Instance Table)
        $table = $sc->createTable("ledger_voucher_instance");
        $table->addColumn('voucher_instance_id','integer',array("unsigned" => true));
        $table->addColumn('voucher_id','integer',array("unsigned" => true));
        $table->addColumn('voucher_full_name','string',array("length"=> 255));
        $table->addColumn('date_created','datatime',array());
        
        $table->setPrimaryKey(array('voucher_instance_id'));
        $table->addForeignKeyConstraint('ledger_voucher_type',array('voucher_id'),array('voucher_id'),'gl_voucher_instance_pk1');
        
        
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

    
    public function buildUtilityTables(Connection $db, ASchema $sc)
    {
        $mockTemporalTable = $sc->createTable('mock_temporal');
        $mockTemporalTable->addColumn('slug_name',"string", array("length" => 150));
        $mockTemporalTable->addColumn('enabled_from',"date",array());
        $mockTemporalTable->addColumn('enabled_to',"date",array());
        $mockTemporalTable->addColumn('posting_date',"date",array());
        $mockTemporalTable->setPrimaryKey(array("slug_name",'enabled_from'));
        $mockTemporalTable->addIndex(array('enabled_to'));
    }
    
    
    public function buildSchema(Connection $db, ASchema $schema)
    {
        # Accounts Group Tables
        //$this->buildAccountsGroupTable($db,$schema);
        
        # Account Table
        //$this->buildAccountsTable($db,$schema);
        
        # Voucher Table
        $this->buildVoucherTable($db,$schema);
        
        # utility tables
        //$this->buildUtilityTables($db,$schema);
        
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
