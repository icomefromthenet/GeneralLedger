<?php
namespace IComeFromTheNet\Ledger\Test;

use IComeFromTheNet\Ledger\Test\Base\TestWithContainer;
use IComeFromTheNet\Ledger\Voucher\Formatter\FormatBagInterface;
use IComeFromTheNet\Ledger\Voucher\Formatter\FormatterBag;
use IComeFromTheNet\Ledger\Voucher\Formatter\FormatterInterface;

/**
  *  Test the Voucher Validation Rule Bag
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class VoucherFormatterBagTest extends TestWithContainer
{
    
    
    public function testAddFormatter()
    {
        $bag = new FormatterBag();
        $formatter = $this->getMock('IComeFromTheNet\Ledger\Voucher\Formatter\FormatterInterface');
        
        $bag->addFormatter('test',$formatter);
    }
    
    /**
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedEXceptionMessage test already been added to the formatter Bag
     *
    */
    public function testErrorAddSameRuleTwice()
    {
        $bag = new FormatterBag();
        $formatter = $this->getMock('IComeFromTheNet\Ledger\Voucher\Formatter\FormatterInterface');
        
        $bag->addFormatter('test',$formatter);
        $bag->addFormatter('test',$formatter);
        
    }
    
    
    public function testRemoveRule()
    {
        $bag = new FormatterBag();
        $formatter = $this->getMock('IComeFromTheNet\Ledger\Voucher\Formatter\FormatterInterface');
        
        $bag->addFormatter('test',$formatter);
        
        $this->assertTrue($bag->removeFormatter('test'));
        $bag->addFormatter('test',$formatter); #'no error'
    }
    
    
    public function testIteratreOverBag()
    {
        $bag = new FormatterBag();
        $formatter = $this->getMock('IComeFromTheNet\Ledger\Voucher\Formatter\FormatterInterface');
        
        $this->assertInstanceOf('IteratorAggregate',$bag);
        $this->assertInstanceOf('Iterator',$bag->getIterator());
    }
    
}
/* End of Class */
