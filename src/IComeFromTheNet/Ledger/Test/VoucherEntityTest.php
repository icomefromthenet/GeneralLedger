<?php
namespace IComeFromTheNet\Ledger\Test;

use DateTime;
use IComeFromTheNet\Ledger\Test\Base\TestWithContainer;
use IComeFromTheNet\Ledger\Voucher\ValidationRuleBag;
use IComeFromTheNet\Ledger\Voucher\Rule\AlwaysValidRule;
use IComeFromTheNet\Ledger\Voucher\Rule\AlwaysInvalidRule;
use IComeFromTheNet\Ledger\Voucher\Strategy\SequenceStrategyInterface;
use IComeFromTheNet\Ledger\Voucher\Formatter\FormatterInterface;
use IComeFromTheNet\Ledger\Voucher\VoucherEntity;

/**
  *  Test the Voucher Entity Object
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class VoucherEntityTest extends TestWithContainer
{
    
    
    
    public function testEntityProperties()
    {
        $ruleBag = new ValidationRuleBag();
        $ruleBag->addRule(new AlwaysValidRule());
        
        $sequence = $this->getMock('IComeFromTheNet\Ledger\Voucher\Strategy\SequenceStrategyInterface');
        $formatter = $this->getMock('IComeFromTheNet\Ledger\Voucher\Formatter\FormatterInterface');
        
        $voucherSlug        = 'invoice';
        $voucherName        = 'Invoice Journals';
        $voucherDescription = 'Voucher Description is for and invoice';
        $voucherEnabledFrom = new DateTime();
        $voucherEnabledTo   = new DateTime();
        $voucherEnabledTo->modify('+1 week');
        $voucherMaxLength   = 10;
        $voucherSuffix      = 'REF_';
        $voucherPrefix      = 'PRE_';
        $voucherPaddingChar = '@';
        
        
        $entity = new VoucherEntity();
        
        $entity->setSlug($voucherSlug);
        $this->assertSame($voucherSlug,$entity->getSlug());
        
        $entity->setName($voucherName);
        $this->assertSame($voucherName,$entity->getName());
        
        $entity->setDescription($voucherDescription);
        $this->assertSame($voucherDescription,$entity->getDescription());
        
        $entity->setEnabledFrom($voucherEnabledFrom);
        $this->assertSame($voucherEnabledFrom,$entity->getEnabledFrom());
        
        $entity->setEnabledTo($voucherEnabledTo);
        $this->assertSame($voucherEnabledTo,$entity->getEnabledTo());
        
        $entity->setPrefix($voucherPrefix);
        $this->assertSame($voucherPrefix,$entity->getPrefix());
        
        $entity->setSuffix($voucherSuffix);
        $this->assertSame($voucherSuffix,$entity->getSuffix());
        
        $entity->setMaxLength($voucherMaxLength);
        $this->assertSame($voucherMaxLength,$entity->getMaxLength());
        
        $entity->setPaddingChar($voucherPaddingChar);
        $this->assertSame($voucherPaddingChar,$entity->getPaddingChar());
        
        $entity->setVoucherFormatter($formatter);
        $this->assertEquals($formatter,$entity->getVoucherFormatter());
        
        $entity->setSequenceStrategy($sequence);
        $this->assertEquals($sequence, $entity->getSequenceStrategy());
        
        $entity->setValidationRuleBag($ruleBag);
        $this->assertEquals($ruleBag,$entity->getValidationRuleBag());
        
    }
    
    
    /**
    *  @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
    *  @expectedExceptionMessage Date the voucher becomes available must occur before the assigned unavailable date
    */
    public function testSetEnabledFromErrorWhenOccursAfterEnabedTo()
    {
        $voucherEnabledFrom = new DateTime();
        $voucherEnabledTo   = new DateTime();
        $voucherEnabledTo->modify('-1 week');
        
        $entity = new VoucherEntity();
        
        $entity->setEnabledTo($voucherEnabledTo);
        $entity->setEnabledFrom($voucherEnabledFrom);
        
    }
    
    /**
    *  @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
    *  @expectedExceptionMessage Date the voucher becomes unavailable must occur after the assigned available date
    */
    public function testSetEnabledToErrorWhenOccursBeforeEnableFrom()
    {
        
        $voucherEnabledFrom = new DateTime();
        $voucherEnabledTo   = new DateTime();
        $voucherEnabledTo->modify('-1 week');
        
        $entity = new VoucherEntity();
        
        $entity->setEnabledFrom($voucherEnabledFrom);
        $entity->setEnabledTo($voucherEnabledTo);
        
        
    }
    
    /**
    *  @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
    *  @expectedExceptionMessage Voucher name must not be empty
    */
    public function testErrorWhenSettingEmptyName()
    {
        $entity = new VoucherEntity();
        $entity->setName(null);
    }
    
    /**
    *  @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
    *  @expectedExceptionMessage Voucher slug must not be empty
    */
    public function testErrorWhenSettingEmptySlug()
    {
        $entity = new VoucherEntity();
        $entity->setSlug(null);
    }
    
    
    public function testValidateRuleBag()
    {
        
        $alwaysValidBag = new ValidationRuleBag();
        $alwaysValidBag->addRule(new AlwaysValidRule());
        
        $alwaysInvalidBag = new ValidationRuleBag();
        $alwaysInvalidBag->addRule(new AlwaysInvalidRule());
        
        $entity = new VoucherEntity();
        $entity->setValidationRuleBag($alwaysValidBag);
        $this->assertTrue($entity->validateReference('b'));
       
        $entity = new VoucherEntity();
        $entity->setValidationRuleBag($alwaysInvalidBag);
        $this->assertFalse($entity->validateReference('a'));
    }
    
    
    public function testGenerateReferenceWithMocks()
    {
              $ruleBag = new ValidationRuleBag();
        $ruleBag->addRule(new AlwaysValidRule());
        
        $sequence = $this->getMock('IComeFromTheNet\Ledger\Voucher\Strategy\SequenceStrategyInterface');
        
        $sequence->expects($this->once())
                 ->method('nextVal')
                 ->with($this->equalTo('invoice'))
                 ->will($this->returnValue(1));
        
        $formatter = $this->getMock('IComeFromTheNet\Ledger\Voucher\Formatter\FormatterInterface');
        
        $formatter->expects($this->once())
                  ->method('format')
                  ->with($this->equalTo(1))
                  ->will($this->returnValue('REF_1'));
        
        $entity = new VoucherEntity();
        
        $entity->setVoucherFormatter($formatter);
        $this->assertEquals($formatter,$entity->getVoucherFormatter());
        
        $entity->setSequenceStrategy($sequence);
        $this->assertEquals($sequence, $entity->getSequenceStrategy());
        
        $entity->setValidationRuleBag($ruleBag);
        $this->assertEquals($ruleBag,$entity->getValidationRuleBag());
        
        $entity->setSlug('invoice');
        
        $this->assertEquals('REF_1',$entity->generateReference());
        
    }
    
    /**
     *  @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     *  @expectedExceptionMessage Generated reference failed to validate, maybe sequence is broken
     * 
     */
    public function testGenerateReferenceWithMocksFailsValidate()
    {
        $ruleBag = new ValidationRuleBag();
        $ruleBag->addRule(new AlwaysInvalidRule());
        
        $sequence = $this->getMock('IComeFromTheNet\Ledger\Voucher\Strategy\SequenceStrategyInterface');
        
        $sequence->expects($this->once())
                 ->method('nextVal')
                 ->with($this->equalTo('invoice'))
                 ->will($this->returnValue(1));
        
        $formatter = $this->getMock('IComeFromTheNet\Ledger\Voucher\Formatter\FormatterInterface');
        
        $formatter->expects($this->once())
                  ->method('format')
                  ->with($this->equalTo(1))
                  ->will($this->returnValue('REF_1'));
        
        $entity = new VoucherEntity();
        
        $entity->setVoucherFormatter($formatter);
        $this->assertEquals($formatter,$entity->getVoucherFormatter());
        
        $entity->setSequenceStrategy($sequence);
        $this->assertEquals($sequence, $entity->getSequenceStrategy());
        
        $entity->setValidationRuleBag($ruleBag);
        $this->assertEquals($ruleBag,$entity->getValidationRuleBag());
        
        $entity->setSlug('invoice');
        
        $entity->generateReference();
        
    }
    
}