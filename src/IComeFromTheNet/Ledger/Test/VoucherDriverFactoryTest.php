<?php
namespace IComeFromTheNet\Ledger\Test;

use IComeFromTheNet\Ledger\Test\Base\TestWithContainer;
use IComeFromTheNet\Ledger\Voucher\Driver\CommonDriverFactory;
use Doctrine\DBAL\Connection;
use IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverInterface;
use IComeFromTheNet\Ledger\Exception\LedgerException;

/**
  *  Test the Voucher Driver Factory
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class VoucherDriverFactoryTest extends TestWithContainer
{
    
    
    const SEQUENCE_TABLE_NAME = 'ledger_voucher';
    
    
    
    public function testRegister()
    {
        $connection = $this->getContainer()->getDoctrineDBAL();
        $event      = $this->getContainer()->getEventDispatcher();
    
        $factory = new CommonDriverFactory($connection,$event);
        $factory->registerDriver('psql','IComeFromTheNet\Ledger\Voucher\Driver\MYSQLDriver');
    }
    
    /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage Platform psql already registered with factory 
    */
    public function testExceptionRegisterExistingDriver()
    {
        $connection = $this->getContainer()->getDoctrineDBAL();
        $event      = $this->getContainer()->getEventDispatcher();
    
        $factory = new CommonDriverFactory($connection,$event);
        
        $factory->registerDriver('psql','IComeFromTheNet\Ledger\Voucher\Driver\MYSQLDriver');
        $factory->registerDriver('psql','IComeFromTheNet\Ledger\Voucher\Driver\MYSQLDriver');
    }
    
    public function testNewDriver()
    {
        $connection = $this->getContainer()->getDoctrineDBAL();
        $event      = $this->getContainer()->getEventDispatcher();
    
        $factory = new CommonDriverFactory($connection,$event);
        
        $this->assertInstanceOf('IComeFromTheNet\Ledger\Voucher\Driver\MYSQLDriver',$factory->getInstance('mysql',self::SEQUENCE_TABLE_NAME));
    }
    
}
/* End of Class */
