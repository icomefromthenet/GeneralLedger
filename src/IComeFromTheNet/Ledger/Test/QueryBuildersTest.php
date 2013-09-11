<?php
namespace IComeFromTheNet\Ledger\Test;

use DateTime;
use DateInterval;
use Doctrine\DBAL\Connection;
use IComeFromTheNet\Ledger\Query\AccountGroupQuery;
use DBALGateway\Table\TableInterface;

/**
  *  Unit test of the QueryBuilders
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class QueryBuildersTest extends \PHPUnit_Framework_TestCase
{
    
    static protected $doctrineConnection;
    
    /**
    * Gets a db connection to the test database
    *
    * @access public
    * @return \Doctrine\DBAL\Connection
    */
    public function getDoctrineConnection()
    {
        if(self::$doctrineConnection === null) {
        
            $config = new \Doctrine\DBAL\Configuration();
            
            $connectionParams = array(
                'dbname' => $GLOBALS['DEMO_DATABASE_SCHEMA'],
                'user' => $GLOBALS['DEMO_DATABASE_USER'],
                'password' => $GLOBALS['DEMO_DATABASE_PASSWORD'],
                'host' => $GLOBALS['DEMO_DATABASE_HOST'],
                'driver' => $GLOBALS['DEMO_DATABASE_TYPE'],
                'port'   => $GLOBALS['DEMO_DATABASE_PORT'],
            );
        
           self::$doctrineConnection = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
        }
        
        return self::$doctrineConnection;
        
    }
    
    
    public function testAccountGroupQuery()
    {
        
        $now = new DateTime();
        $finished = new \IComeFromTheNet\Ledger\AccountsList;
        
        $finished->getAccounts($now);
        
        
        $gateway = $this->getMock('DBALGateway\Table\TableInterface');
        $meta    = 
        
        # test filter by parent
        $query = new AccountGroupQuery($this->getDoctrineConnection(),$gateway);
     
        
     
        
    }
    
}