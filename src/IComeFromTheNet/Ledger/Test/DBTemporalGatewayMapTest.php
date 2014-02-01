<?php
namespace IComeFromTheNet\Ledger\Test;

use DateTime;
use DateInterval;
use Doctrine\DBAL\Schema\Column;
use IComeFromTheNet\Ledger\Entity\TemporalMap;
use IComeFromTheNet\Ledger\Entity\TemporalGatewayInterface;
use IComeFromTheNet\Ledger\Entity\TemporalGatewayDecerator;
use IComeFromTheNet\Ledger\Exception\LedgerException;

/**
  *  Unit test of the Temporal Map
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class DBTemporalGatewayTest extends \PHPUnit_Framework_TestCase
{
 
  public function testMapProperties()
  {
      $slugColumn = $this->getMockBuilder('Doctrine\DBAL\Schema\Column')->disableOriginalConstructor()->getMock();
      $fromColumn = $this->getMockBuilder('Doctrine\DBAL\Schema\Column')->disableOriginalConstructor()->getMock();
      $toColumn   = $this->getMockBuilder('Doctrine\DBAL\Schema\Column')->disableOriginalConstructor()->getMock();
      
      $map = new TemporalMap($slugColumn,$fromColumn,$toColumn);
      
      //\Psy\Shell::debug(get_defined_vars());
      
      $this->assertSame($slugColumn,$map->getSlugColumn());
      $this->assertSame($toColumn,$map->getToColumn());
      $this->assertSame($fromColumn,$map->getFromColumn());
      
  }
 
 
  public function testGatewayProperties()
  {
    $tableGateway    = $this->getMock('\IComeFromTheNet\Ledger\Entity\TemporalGatewayInterface');
    $processingDate  = new DateTime('Yesterday');
    $maxDate         = new DateTime('3000-01-01 00:00:00');
    $minSlotInterval = new DateInterval('P0000-00-00T23:59:59');
     
    $decerator       = new TemporalGatewayDecerator($tableGateway,$processingDate,$maxDate,$minSlotInterval);
     
     
    $this->assertSame($tableGateway,$decerator->getTableGateway());
    $this->assertSame($processingDate,$decerator->getProcessingDate());
    $this->assertSame($maxDate,$decerator->getMaxDate());
    $this->assertSame($minSlotInterval,$decerator->getMinSlotInterval());
     
  }
  
  /**
   * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
   * @expectedExceptionMessage The opening from date occurs after the closing to date
   * 
   */ 
  public function testValidationExceptionWhenDatesSwaped()
  {
    $tableGateway    = $this->getMock('\IComeFromTheNet\Ledger\Entity\TemporalGatewayInterface');
    $processingDate  = new DateTime('Yesterday');
    $maxDate         = new DateTime('3000-01-01 00:00:00');
    $minSlotInterval = new DateInterval('P0000-00-00T23:59:59'); 
    $decerator       = new TemporalGatewayDecerator($tableGateway,$processingDate,$maxDate,$minSlotInterval);
     
    $from = new DateTime('now');
    $to   = new DateTime('today - 3days');
     
    $decerator->isSlotAvailable('no-query', $from, $to);
    
    
      
  }
  
  /**
   * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
   * @expectedExceptionMessage The length of the slot is below the minimum allowed
   * 
   */ 
  public function testValidationExceptionWhenMinSlotNotMet()
  {
    $tableGateway    = $this->getMock('\IComeFromTheNet\Ledger\Entity\TemporalGatewayInterface');
    $processingDate  = new DateTime('Yesterday');
    $maxDate         = new DateTime('3000-01-01 00:00:00');
    $minSlotInterval = new DateInterval('P0000-00-00T23:59:59'); 
    $decerator       = new TemporalGatewayDecerator($tableGateway,$processingDate,$maxDate,$minSlotInterval);
     
    $from = new DateTime('now');
    $to   = new DateTime('now');
     
    $decerator->isSlotAvailable('no-query', $from, $to);
  }
 
 
  public function testIsSlotAvaiable()
  {
      
      
  }
 
}
/* End of File */