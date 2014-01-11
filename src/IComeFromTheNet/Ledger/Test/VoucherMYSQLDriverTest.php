<?php
namespace IComeFromTheNet\Ledger\Test;

use IComeFromTheNet\Ledger\Test\Base\TestWithContainer;
use IComeFromTheNet\Ledger\Voucher\Driver\MYSQLDriver;
use Doctrine\DBAL\Connection;
use IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverInterface;
use IComeFromTheNet\Ledger\Exception\LedgerException;

/**
  *  Test the Voucher MYSQL Sequence Driver
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class VoucherMYSQLDriverTest extends TestWithContainer
{
    
    
    const SEQUENCE_TABLE_NAME = 'ledger_voucher';
    
    
    public function testNewDriver()
    {
        $connection = $this->getContainer()->getDoctrineDBAL();
        $schema     = $this->getContainer()->getDatabaseSchema();
        
        $this->assertTrue($schema->hasTable(self::SEQUENCE_TABLE_NAME),'Database is missing sequence table::'.self::SEQUENCE_TABLE_NAME);
        
        $driver = new MYSQLDriver($connection,self::SEQUENCE_TABLE_NAME);
        
        $this->assertInstanceOf('IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverInterface',$driver);    
    }
    
    
    public function testSequenceReturnsValueOnValidSequence()
    {
        $connection = $this->getContainer()->getDoctrineDBAL();
        $schema     = $this->getContainer()->getDatabaseSchema();
        $driver = new MYSQLDriver($connection,self::SEQUENCE_TABLE_NAME);
        
        $seq = $driver->sequence('invoice');
        
        $this->assertInternalType('integer',$seq);
        $this->assertGreaterThan(0,$seq,'sequence is not greater than 0');
        
        $seq2 = $driver->sequence('invoice');
        
        $this->assertEquals($seq+1,$seq2);
        
    }
    
    /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExcetpionMessage Unable to update voucher sequence with name aaaa
    */
    public function testSequenceErrorWhenVoucherNotExist()
    {
        $connection = $this->getContainer()->getDoctrineDBAL();
        $schema     = $this->getContainer()->getDatabaseSchema();
        $driver = new MYSQLDriver($connection,self::SEQUENCE_TABLE_NAME);
        
        $seq = $driver->sequence('aaaa');
        
    }
    
    
    public function testUUIDReturnsValue()
    {
        $connection = $this->getContainer()->getDoctrineDBAL();
        $schema     = $this->getContainer()->getDatabaseSchema();
        $driver = new MYSQLDriver($connection,self::SEQUENCE_TABLE_NAME);
        
        $seq = $driver->uuid('');
        $this->assertRegExp('/[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}/',$seq);
        $seq2 = $driver->uuid('');
        
        $this->assertNotEquals($seq,$seq2);
    }
    
}
/* End of Class */
