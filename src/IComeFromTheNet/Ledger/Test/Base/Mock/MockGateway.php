<?php
namespace IComeFromTheNet\Ledger\Test\Base\Mock;

use IComeFromTheNet\Ledger\DB\TemporalGatewayInterface;
use IComeFromTheNet\Ledger\DB\TemporalMap;
use DBALGateway\Table\AbstractTable;
use Doctrine\DBAL\Schema;
use Doctrine\DBAL\Schema\Table;

class MockGateway extends AbstractTable implements TemporalGatewayInterface
{
    
    protected static $schemaDetails;
    
    public function newQueryBuilder()
    {
        return new MockQuery($this->adapter,$this);
    }
    
    
    public function getTemporalColumns()
    {
        $table = self::getTableMetaData();
        
        return new TemporalMap($table->getColumn('slug_name'),
                               $table->getColumn('enabled_from'),
                               $table->getColumn('enabled_to'),
                               $table->getColumn('posting_date'));
        
    }
    
    public static function getTableMetaData()
    {
        if(self::$schemaDetails === null) {
            $table = new Table('mock_temporal');
        
            $table->addColumn('slug_name',"string", array("length" => 150));
            $table->addColumn('enabled_from',"date",array());
            $table->addColumn('enabled_to',"date",array());
            $table->addColumn('posting_date',"date",array());
        
            self::$schemaDetails = $table;
        }
        
        return self::$schemaDetails;
        
    }
    
    
    
    
}
/* End of File */



