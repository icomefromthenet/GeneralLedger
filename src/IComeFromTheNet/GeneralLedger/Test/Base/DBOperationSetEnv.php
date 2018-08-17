<?php
namespace IComeFromTheNet\GeneralLedger\Test\Base;

use PHPUnit\DbUnit\Operation\Operation; 
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\DataSet\IDataSet;


class DBOperationSetEnv implements Operation
{
    private $env;
    private $val;

    public function __construct($env,$val)
    {
        $this->env = $env;
        $this->val = $val;
    }

    public function execute(Connection $connection, IDataSet $dataSet)
    {
        $connection->getConnection()->query('SET '.$this->env.'='.$this->val);
    }
}
/* End of File */