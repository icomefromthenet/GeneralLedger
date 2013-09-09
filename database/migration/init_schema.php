<?php
namespace Migration\Components\Migration\Entities;

use Doctrine\DBAL\Connection,
    Doctrine\DBAL\Schema\AbstractSchemaManager as Schema,
    Migration\Components\Migration\EntityInterface;

class init_schema implements EntityInterface
{

    public function up(Connection $db, Schema $sc)
    {
        # Account Group Table
        $schema = new \Doctrine\DBAL\Schema\Schema();
        $accountGroupTable = $schema->createTable("ledger_account_group");
        $accountGroupTable->addColumn("group_id", "integer", array("unsigned" => true));
        $accountGroupTable->addColumn("group_name", "string", array("length" => 50));
        $accountGroupTable->addColumn("group_description", "string", array("length" => 150));
        $accountGroupTable->addColumn("group_date_added", "date",array());
        $accountGroupTable->addColumn("group_date_removed", "date",array());
        $accountGroupTable->addColumn("parent_group_id", "integer", array("unsigned" => true));
        $accountGroupTable->setPrimaryKey(array("group_id"));
        $accountGroupTable->addForeignKeyConstraint($accountGroupTable,
                                                    array("parent_group_id"), array("group_id"), array("onUpdate" => "CASCADE"));
        
        # Account Table
    
        $accountTable = $schema->createTable("ledger_account");
        $accountTable->addColumn("account_number", "integer", array("unsigned" => true));
        $accountTable->addColumn("group_id", "integer", array("unsigned" => true));
        
        
        $accountTable->setPrimaryKey(array("account_number"));
        $accountTable->addForeignKeyConstraint($accountGroupTable, array("group_id"), array("group_id"), array("onUpdate" => "CASCADE"));

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
