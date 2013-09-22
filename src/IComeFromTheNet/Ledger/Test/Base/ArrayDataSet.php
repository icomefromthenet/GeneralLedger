<?php
namespace IComeFromTheNet\Ledger\Test\Base;

use InvalidArgumentException;
use PHPUnit_Extensions_Database_DataSet_AbstractDataSet;
use PHPUnit_Extensions_Database_DataSet_DefaultTableMetaData;
use PHPUnit_Extensions_Database_DataSet_DefaultTable;
use PHPUnit_Extensions_Database_DataSet_DefaultTableIterator;
 
/**
 *  Adds Array dataset to the test lib
 *
 *  @access public
 *  @return void
 *  @link http://phpunit.de/manual/current/en/database.html#database.run-test-verify-outcome-and-teardown
 *  @example return new self(array(
 *           'guestbook' => array(
 *              array('id' => 1, 'content' => 'Hello buddy!', 'user' => 'joe', 'created' => '2010-04-24 17:15:23'),
 *               array('id' => 2, 'content' => 'I like it!',   'user' => null,  'created' => '2010-04-26 12:14:20'),
 *           ),
 *       ));
 *
*/
class ArrayDataSet extends PHPUnit_Extensions_Database_DataSet_AbstractDataSet
{
    /**
     * @var array
     */
    protected $tables = array();
 
    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        foreach ($data AS $tableName => $rows) {
            $columns = array();
            if (isset($rows[0])) {
                $columns = array_keys($rows[0]);
            }
 
            $metaData = new PHPUnit_Extensions_Database_DataSet_DefaultTableMetaData($tableName, $columns);
            $table = new PHPUnit_Extensions_Database_DataSet_DefaultTable($metaData);
 
            foreach ($rows as $row) {
                $table->addRow($row);
            }
            $this->tables[$tableName] = $table;
        }
    }
 
    protected function createIterator($reverse = FALSE)
    {
        return new PHPUnit_Extensions_Database_DataSet_DefaultTableIterator($this->tables, $reverse);
    }
 
    public function getTable($tableName)
    {
        if (!isset($this->tables[$tableName])) {
            throw new InvalidArgumentException("$tableName is not a table in the current database.");
        }
 
        return $this->tables[$tableName];
    }
}

/* End of File  */