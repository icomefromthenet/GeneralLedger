<?php
namespace IComeFromTheNet\Ledger\Test;


use Doctrine\DBAL\Schema\Column;
use IComeFromTheNet\Ledger\Entity\TemporalMap;

/**
  *  Unit test of the Temporal Map
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class EntityTemporalMapTest extends \PHPUnit_Framework_TestCase
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
 
 
}
/* End of File */