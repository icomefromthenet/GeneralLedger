<?php

namespace IComeFromTheNet\Ledger\Test;

use IComeFromTheNet\Ledger\Test\Base\TestWithContainer;
use Doctrine\DBAL\Connection;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use IComeFromTheNet\Ledger\Exception\LedgerException;
use IComeFromTheNet\Ledger\Voucher\Strategy\AutoIncrementStrategy;
use IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverInterface;
use IComeFromTheNet\Ledger\Voucher\Strategy\SequenceStrategyInterface;
use IComeFromTheNet\Ledger\Voucher\SequenceInterface;
use IComeFromTheNet\Ledger\Voucher\Event\VoucherEvents;
use IComeFromTheNet\Ledger\Voucher\Event\SequenceEvent;

/**
  *  Test the Voucher AutoIncrementStrategy
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class VoucherAutoIncrementStrategyTest extends TestWithContainer
{
 
   public function testNewStrategy()
   {
      $driver = $this->getMock('IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverInterface');
      $event  = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
     
      $strategy = new AutoIncrementStrategy($driver,$event);
    
      $this->assertInstanceOf('IComeFromTheNet\Ledger\Voucher\Strategy\SequenceStrategyInterface',$strategy);
      $this->assertInstanceOf('IComeFromTheNet\Ledger\Voucher\SequenceInterface',$strategy);
   }
 
 
   public function testProperties()
   {
      $driver = $this->getMock('IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverInterface');
      $event  = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
     
      $strategy = new AutoIncrementStrategy($driver,$event);
      
      $this->assertEquals($driver,$strategy->getDriver());
      $this->assertEquals($event,$strategy->getEventDispatcher());
      $this->assertEquals('sequence',$strategy->getStrategyName());
    
   }
   
   
   public function testNextVal()
   {
    
      $driver = $this->getMock('IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverInterface');
      $event  = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
      $seqName = 'invoice';
     
      $driver->expects($this->once())
             ->method('sequence')
             ->with($this->equalTo($seqName))
             ->will($this->returnValue(100));
     
      $event->expects($this->at(0))
            ->method('dispatch')
            ->with($this->equalTo(VoucherEvents::SEQUENCE_BEFORE),$this->isInstanceOf('IComeFromTheNet\Ledger\Voucher\Event\SequenceEvent'));
      
      $event->expects($this->at(1))
            ->method('dispatch')
            ->with($this->equalTo(VoucherEvents::SEQUENCE_AFTER),$this->isInstanceOf('IComeFromTheNet\Ledger\Voucher\Event\SequenceEvent'));
     
      $strategy = new AutoIncrementStrategy($driver,$event);
      
      $this->assertEquals(100,$strategy->nextVal($seqName));
    
   }
   
   /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExcetpionMessage Unable to update voucher sequence with name invoice
    */
   public function testEsceptionNextValDriverThrowsException()
   {
    
      $driver = $this->getMock('IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverInterface');
      $event  = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
      $seqName = 'invoice';
     
      $driver->expects($this->once())
             ->method('sequence')
             ->with($this->equalTo($seqName))
             ->will($this->throwException(new LedgerException('Unable to update voucher sequence with name invoice')));
     
      $event->expects($this->at(0))
            ->method('dispatch')
            ->with($this->equalTo(VoucherEvents::SEQUENCE_BEFORE),$this->isInstanceOf('IComeFromTheNet\Ledger\Voucher\Event\SequenceEvent'));
      
      $strategy = new AutoIncrementStrategy($driver,$event);
      
      $this->assertEquals(100,$strategy->nextVal($seqName));
    
   }
   
   
}