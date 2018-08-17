<?php
namespace IComeFromTheNet\GeneralLedger\Test\Base;

use PHPUnit\DbUnit\DataSet\AbstractDataSet;
use PHPUnit\DbUnit\DataSet\DefaultTableIterator;
use PHPUnit\DbUnit\DataSet\DefaultTableMetadata;
use PHPUnit\DbUnit\DataSet\DefaultTable;

class ArrayDataSet extends AbstractDataSet
{
    /**
     * @var array
     */
    protected $tables = [];

    /**
     * Creates a new dataset
     *
     * @param mixed $files
     */
    public function __construct($files = null)
    {
        if (is_array($files)) {
            foreach ($files as $file) {
                $this->addFile($file);
            }
        } else if ($files) {
            $this->addFile($files);
        }
    }

    /**
     * Adds a new file to the dataset.
     * @param string $file
     */
    public function addFile($file)
    {
        $data = require $file;

        foreach ($data as $tableName => $rows) {
            if (!isset($rows)) {
                $rows = array();
            }

            if (!is_array($rows)) {
                continue;
            }

            if (!array_key_exists($tableName, $this->tables)) {
                $columns = array_keys($rows[0]);

                $tableMetaData = new DefaultTableMetadata(
                    $tableName,
                    $columns
                );

                $this->tables[$tableName] = new DefaultTable(
                    $tableMetaData
                );
            }

            foreach ($rows as $row) {
                $this->tables[$tableName]->addRow($row);
            }
        }
    }

    /**
     * Creates an iterator over the tables in the data set. If $reverse is
     * true a reverse iterator will be returned.
     *
     * @param bool $reverse
     * @return \PHPUnit\DbUnit\DataSet\DefaultTableIterator
     */
    protected function createIterator($reverse = false)
    {
        return new DefaultTableIterator(
            $this->tables,
            $reverse
        );
    }
}