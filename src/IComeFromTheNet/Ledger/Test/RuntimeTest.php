<?php
namespace IComeFromTheNet\Ledger\Test;

use Exception;
use DateTime;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use IComeFromTheNet\Ledger\LedgerRuntime;
use IComeFromTheNet\Ledger\Exception\LedgerException;
use IComeFromTheNet\Ledger\Test\Base\TestWithFixture;
use IComeFromTheNet\Ledger\Event\Runtime\RuntimeEvent;
use IComeFromTheNet\Ledger\Event\Runtime\RuntimeEvents;
use IComeFromTheNet\Ledger\Service\LedgerServiceProvider;

/**
  *  Unit test of the Runtime Loader
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class RuntimeTest extends TestWithFixture
{
    
    public function testNewInstance()
    {
        $doctrine = $this->getDoctrineConnection();
        $logger   = $this->getMock('Psr\Log\LoggerInterface');
        $event    = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        
        $processingDate = new DateTime();
        $occuredDate    = new DateTime();
        
        $event->expects($this->at(0))
              ->method('dispatch')
              ->with($this->equalTo(RuntimeEvents::EVENT_RUNTIME_BEFORE_BOOT),$this->isInstanceOf('IComeFromTheNet\Ledger\Event\Runtime\RuntimeEvent'));
        
        $event->expects($this->at(1))
              ->method('dispatch')
              ->with($this->equalTo(RuntimeEvents::EVENT_RUNTIME_AFTER_BOOT),$this->isInstanceOf('IComeFromTheNet\Ledger\Event\Runtime\RuntimeEvent'));
              
        $runtime = new LedgerRuntime($event,$doctrine,$logger);
        $ledger  = $runtime->assemble($processingDate,$occuredDate);
        
        
        # assert Dates are same objects
        $this->assertSame($processingDate,$ledger->getProcessingDate());
        $this->assertSame($occuredDate,$ledger->getOccuredDate());
     
        return array($runtime,$ledger);  
    }
    
    /*
     * @depends testNewInstance
     * 
     */
    public function testSameInstanceWhenOccuredDateSame()
    {
        $result  = $this->testNewInstance();
        $runtime = $result[0];
        $ledger  = $result[1];
        
        $processingDate = new DateTime();
        $occuredDate    = new DateTime();
        
        $processingDate->modify('+ 3 days');
        
        $this->assertSame($ledger,$runtime->assemble($processingDate,$occuredDate));
    }
    
     /*
     * @depends testNewInstance
     * 
     */
    public function testNewInstanceWhenSameProcessingButNewOccuredDate()
    {
        $result  = $this->testNewInstance();
        $runtime = $result[0];
        $ledger  = $result[1];
        
        $processingDate = new DateTime();
        $occuredDate    = new DateTime();
        $occuredDate->modify('-6 days');
        
        $this->assertNotSame($ledger,$runtime->assemble($processingDate,$occuredDate));
    }
    
    
    public function testNewInstaneWithOnlyProcessingDate()
    {
        $doctrine = $this->getDoctrineConnection();
        $logger   = $this->getMock('Psr\Log\LoggerInterface');
        $event    = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        
        $processingDate = new DateTime();
        $occuredDate    = null;
        
        $event->expects($this->at(0))
              ->method('dispatch')
              ->with($this->equalTo(RuntimeEvents::EVENT_RUNTIME_BEFORE_BOOT),$this->isInstanceOf('IComeFromTheNet\Ledger\Event\Runtime\RuntimeEvent'));
        
        $event->expects($this->at(1))
              ->method('dispatch')
              ->with($this->equalTo(RuntimeEvents::EVENT_RUNTIME_AFTER_BOOT),$this->isInstanceOf('IComeFromTheNet\Ledger\Event\Runtime\RuntimeEvent'));
              
        $runtime = new LedgerRuntime($event,$doctrine,$logger);
        $ledger  = $runtime->assemble($processingDate,$occuredDate);
     
     
        # assert Dates are same objects
        $this->assertSame($processingDate,$ledger->getProcessingDate());
        $this->assertEquals($processingDate,$ledger->getOccuredDate());
    }
    
   /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage a ledger exception has been caught
     * 
    */ 
    public function testNewInstanceWithLedgerExceptionOccuring()
    {
        $doctrine = $this->getDoctrineConnection();
        $logger   = $this->getMock('Psr\Log\LoggerInterface');
        $event    = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        
        $processingDate = new DateTime();
        $occuredDate    = new DateTime();
        
        $event->expects($this->at(0))
              ->method('dispatch')
              ->with($this->equalTo(RuntimeEvents::EVENT_RUNTIME_BEFORE_BOOT),$this->isInstanceOf('IComeFromTheNet\Ledger\Event\Runtime\RuntimeEvent'))
              ->will($this->throwException(new LedgerException('a ledger exception has been caught')));
        
        $runtime = new LedgerRuntime($event,$doctrine,$logger);
        $ledger  = $runtime->assemble($processingDate,$occuredDate);

        
    }
    
    
   /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage an exception has been caught an thrown as ledgerException
     * 
    */ 
    public function testNewInstanceWithExceptionOccuring()
    {
        $doctrine = $this->getDoctrineConnection();
        $logger   = $this->getMock('Psr\Log\LoggerInterface');
        $event    = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        
        $processingDate = new DateTime();
        $occuredDate    = new DateTime();
        
        $event->expects($this->at(0))
              ->method('dispatch')
              ->with($this->equalTo(RuntimeEvents::EVENT_RUNTIME_BEFORE_BOOT),$this->isInstanceOf('IComeFromTheNet\Ledger\Event\Runtime\RuntimeEvent'))
              ->will($this->throwException(new Exception('an exception has been caught an thrown as ledgerException')));
        
        $runtime = new LedgerRuntime($event,$doctrine,$logger);
        $ledger  = $runtime->assemble($processingDate,$occuredDate);

        
    }
        
}
/* End of File */    
    