<?php

namespace IComeFromTheNet\Ledger\Test;

use IComeFromTheNet\Ledger\Test\Base\TestWithContainer;
use Doctrine\DBAL\Connection;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use IComeFromTheNet\Ledger\Exception\LedgerException;
use IComeFromTheNet\Ledger\Voucher\Strategy\UUIDStrategy;
use IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverInterface;
use IComeFromTheNet\Ledger\Voucher\Strategy\SequenceStrategyInterface;
use IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverFactoryInterface;
use IComeFromTheNet\Ledger\Voucher\Strategy\StrategyFactoryInterface;
use IComeFromTheNet\Ledger\Voucher\SequenceInterface;
use IComeFromTheNet\Ledger\Voucher\Event\VoucherEvents;
use IComeFromTheNet\Ledger\Voucher\Event\StrategyFactoryEvent;
use IComeFromTheNet\Ledger\Voucher\Strategy\CommonStrategyFactory;
use IComeFromTheNet\Ledger\Voucher\Strategy\AutoIncrementStrategy;

/**
  *  Test the Voucher UUIDStrategyFactory
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class VoucherStrategyFactoryTest extends TestWithContainer
{
 
   public function testNewFactory()
   {
      $driver = $this->getMock('IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverFactoryInterface');
      $event  = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
     
      $strategy = new  CommonStrategyFactory($driver,$event);
    
      $this->assertInstanceOf('IComeFromTheNet\Ledger\Voucher\Strategy\StrategyFactoryInterface',$strategy);
   }
 
   public function testRegisterNew()
   {
      $driver = $this->getMock('IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverFactoryInterface');
      $event  = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
    
      $event->expects($this->at(2))
            ->method('dispatch')
            ->with($this->equalTo(VoucherEvents::SEQUENCE_STRATEGY_REGISTERED),$this->isInstanceOf('IComeFromTheNet\Ledger\Voucher\Event\StrategyFactoryEvent'));
     
      $strategy = new  CommonStrategyFactory($driver,$event);
    
      $strategy->registerStrategy('aaa','IComeFromTheNet\Ledger\Voucher\Strategy\AutoIncrementStrategy');
    
    
   }
 
    /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExcetpionMessage Sequence strategy sequence already registered with factory
    */
   public function testRegisterErrorWhenAlreadySet()
   {
      $driver = $this->getMock('IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverFactoryInterface');
      $event  = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
     
      $strategy = new  CommonStrategyFactory($driver,$event);
    
      $strategy->registerStrategy('sequence','IComeFromTheNet\\Ledger\\Voucher\\Strategy\\AutoIncrementStrategy');
    
   }
   
   /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExcetpionMessage Sequence strategy aaa does not exist
    */
   public function testRegisterErrorWhenNotExist()
   {
      $driver = $this->getMock('IComeFromTheNet\Ledger\Voucher\Driver\SequenceDriverFactoryInterface');
      $event  = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
     
      $strategy = new  CommonStrategyFactory($driver,$event);
    
      $strategy->registerStrategy('aaa','IComeFromTheNet\\Ledger\\Voucher\\Strategy\\AutoIncrementStrategysss');
    
   }
   
}