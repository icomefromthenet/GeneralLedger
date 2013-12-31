<?php
namespace Migration\Components\Migration\Entities;

use Migration\Database\Handler,
    Doctrine\DBAL\Schema\AbstractSchemaManager as Schema,
    Migration\Components\Migration\EntityInterface;

class test_data implements EntityInterface
{
    
    protected function insertDefaultSequences()
    {
        $db->insert('ledger_voucher_sequences', array('sequence_name' => 'test_sequence','sequence_no' => 0));
        
    }
    
    
    public function up(Connection $db, Schema $sc)
    {


    }

    public function down(Connection $db, Schema $sc)
    {


    }


}
/* End of File */
