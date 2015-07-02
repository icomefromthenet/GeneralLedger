<?php
namespace IComeFromTheNet\Ledger\Test;

use IComeFromTheNet\Ledger\Test\Base\TestWithContainer;
use IComeFromTheNet\Ledger\Voucher\Formatter\FormatBagInterface;
use IComeFromTheNet\Ledger\Voucher\Formatter\FormatterBag;
use IComeFromTheNet\Ledger\Voucher\Formatter\FormatterInterface;
use IComeFromTheNet\Ledger\Voucher\Formatter\DefaultFormatter;
use IComeFromTheNet\Ledger\Voucher\Formatter\PassThroughFormatter;
use Zend\Stdlib\StringWrapper\MbString;

/**
  *  Test the Voucher Default Formatter
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class VoucherDefaultFormatterTest extends TestWithContainer
{
    
    
    public function testNewFormatter()
    {
        $prefix    = '';
        $suffix    = '';
        $wrapper   = new MbString();
        $maxLength = 10;
        $paddingChar = '@';
        
        $formatter = new DefaultFormatter($wrapper,$suffix,$prefix,$maxLength,$paddingChar);
        
        $this->assertInstanceOf('IComeFromTheNet\Ledger\Voucher\Formatter\FormatterInterface',$formatter);
        
        $this->assertEquals($paddingChar,$formatter->getPadding());
        $this->assertEquals($maxLength,$formatter->getMaxLength());
        $this->assertEquals($suffix,$formatter->getSuffix());
        $this->assertEquals($prefix,$formatter->getPrefix());
        $this->assertEquals($wrapper,$formatter->getStringWrapper());
        
    }
    
    
    public function testFormatWithPrefix()
    {
        $prefix    = 'INV_';
        $suffix    = null;
        $wrapper   = new MbString();
        $maxLength = null;
        $paddingChar = '@';
        
        $formatter = new DefaultFormatter($wrapper,$suffix,$prefix,$maxLength,$paddingChar);
        
        $this->assertEquals('INV_1',$formatter->format(1));
    }
    
    public function testFormatWithPrefixAndMaxLengthNoPadding()
    {
        $prefix    = 'INV_';
        $suffix    = null;
        $wrapper   = new MbString();
        $maxLength = 5;
        $paddingChar = '@';
        
        $formatter = new DefaultFormatter($wrapper,$suffix,$prefix,$maxLength,$paddingChar);
        
        $this->assertEquals('INV_1',$formatter->format(1));
        
    }
    
    public function testFormatWithPrefixAndMaxLengthAndPadding()
    {
        $prefix    = 'INV_';
        $suffix    = null;
        $wrapper   = new MbString();
        $maxLength = 10;
        $paddingChar = '@';
        
        $formatter = new DefaultFormatter($wrapper,$suffix,$prefix,$maxLength,$paddingChar);
        
        $this->assertEquals('INV_1@@@@',$formatter->format(1));
        
    }
    
    public function testFormatWithSuffixNoPadding()
    {
        $prefix      = null;
        $suffix      = '_INV';
        $wrapper     = new MbString();
        $maxLength   = null;
        $paddingChar = '@';
        
        $formatter = new DefaultFormatter($wrapper,$suffix,$prefix,$maxLength,$paddingChar);
        
        $this->assertEquals('1_INV',$formatter->format(1));
        
    }
    
    public function testFormatWithSuffixMaxLengthAndPadding()
    {
        $prefix      = null;
        $suffix      = '_INV';
        $wrapper     = new MbString();
        $maxLength   = 10;
        $paddingChar = '@';
        
        $formatter = new DefaultFormatter($wrapper,$suffix,$prefix,$maxLength,$paddingChar);
        
        $this->assertEquals('1_INV@@@@',$formatter->format(1));
        
    }
    
    public function testFormatWithSuffixAndPrefixNopPdding()
    {
        $prefix      = 'REF_';
        $suffix      = '_INV';
        $wrapper     = new MbString();
        $maxLength   = null;
        $paddingChar = '@';
        
        $formatter = new DefaultFormatter($wrapper,$suffix,$prefix,$maxLength,$paddingChar);
        
        $this->assertEquals('REF_1_INV',$formatter->format(1));
        
    }
    
    public function testFormatWithSuffixAndPrefixMaxLengthAndNoPadding()
    {
        $prefix      = 'REF_';
        $suffix      = '_INV';
        $wrapper     = new MbString();
        $maxLength   = 10;
        $paddingChar = '@';
        
        $formatter = new DefaultFormatter($wrapper,$suffix,$prefix,$maxLength,$paddingChar);
        
        $this->assertEquals('REF_1_INV',$formatter->format(1));
        
    }
    
    public function testFormatWithSuffixAndPrefixMaxLengthAndPadding()
    {
        $prefix      = 'REF_';
        $suffix      = '_INV';
        $wrapper     = new MbString();
        $maxLength   = 12;
        $paddingChar = '@';
        
        $formatter = new DefaultFormatter($wrapper,$suffix,$prefix,$maxLength,$paddingChar);
        
        $this->assertEquals('REF_1_INV@@',$formatter->format(1));
        
    }
    
    public function testFormatCutoffFromMaxLength()
    {
        $prefix      = 'REF_';
        $suffix      = '_INV';
        $wrapper     = new MbString();
        $maxLength   = 8;
        $paddingChar = '@';
        
        $formatter = new DefaultFormatter($wrapper,$suffix,$prefix,$maxLength,$paddingChar);
        
        $this->assertEquals('REF_1_I',$formatter->format(1));
        
    }

    //-------------------------------------------------------
    # Test of the PassThroughFormatter    
    
    public function testPassThroughFormatter()
    {
        $formatter = new PassThroughFormatter();
        $this->assertEquals(1,$formatter->format(1));
        $this->assertEquals(100,$formatter->format(100));
    }
    
    
}
/* End of Class */