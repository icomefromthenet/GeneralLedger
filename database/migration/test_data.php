<?php
namespace Migration\Components\Migration\Entities;

use Migration\Database\Handler;
use Doctrine\DBAL\Schema\AbstractSchemaManager as Schema;
use Migration\Components\Migration\EntityInterface;
use Doctrine\DBAL\Connection;

class test_data implements EntityInterface
{
    
    protected function insertDefaultSequences($db)
    {
        $db->insert('ledger_voucher',


                );
    }
    
    
    public function up(Connection $db, Schema $sc)
    {
        $this->insertDefaultSequences($db);

    }

    public function down(Connection $db, Schema $sc)
    {


    }


}
/* End of File */
