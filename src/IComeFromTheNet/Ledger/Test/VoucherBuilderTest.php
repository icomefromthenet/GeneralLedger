<?php
namespace IComeFromTheNet\Ledger\Test;

use DateTime;
use IComeFromTheNet\Ledger\Test\Base\TestWithContainer;
use IComeFromTheNet\Ledger\Voucher\ValidationRuleBag;
use IComeFromTheNet\Ledger\Voucher\Strategy\StrategyFactoryInterface;
use IComeFromTheNet\Ledger\Voucher\Formatter\FormatterBagInterface;
use IComeFromTheNet\Ledger\Voucher\VoucherEntity;
use IComeFromTheNet\Ledger\Voucher\VoucherBuilder;

class VoucherBuilderTest extends TestWithContainer
{
    
    public function testNewBuilder()
    {
        $bag             = new ValidationRuleBag();
        $strategyFactory = $this->getMock('IComeFromTheNet\Ledger\Voucher\Strategy\StrategyFactoryInterface');
        $formatterBag    = $this->getMock('IComeFromTheNet\Ledger\Voucher\Formatter\FormatterBagInterface');
        $platform        = 'mysql';
        
        
        $builder = new VoucherBuilder($formatterBag,$strategyFactory,$bag,$platform);
        
        $this->assertInstanceOf('Aura\Marshal\Entity\BuilderInterface',$builder);
        $this->assertInstanceOf('DBALGateway\Builder\BuilderInterface',$builder);
    }
    
    public function testNewEntity()
    {
        $data['voucher_slug'] = 'invoice';
        $data["voucher_enabled_from"] = new DateTime();
        $data["voucher_enabled_to"]  = new DateTime();
        $data["voucher_enabled_to"]->modify('+1 week');
        $data['voucher_name'] = 'Invoice Journal';
        $data['voucher_description'] = 'This is a description';
        $data['voucher_prefix'] = 'inv_';
        $data['voucher_suffix'] = '_jou';
        $data['voucher_maxlength'] = 10;
        $data['voucher_formatter'] = 'default';
        $data['voucher_sequence_strategy'] = 'uuid';
        $data['voucher_sequence_no'] = 1;
        $data['voucher_sequence_padding_char'] ='@';
        
        $bag             = new ValidationRuleBag();
        $strategyFactory = $this->getMock('IComeFromTheNet\Ledger\Voucher\Strategy\StrategyFactoryInterface');
        $formatterBag    = $this->getMock('IComeFromTheNet\Ledger\Voucher\Formatter\FormatterBagInterface');
        $platform        = 'mysql';
        
        $formatterInstance = $this->getMock('IComeFromTheNet\Ledger\Voucher\Formatter\FormatterInterface');
        
        $formatterBag->expects($this->once())
                        ->method('getFormatter')
                        ->with()
                        ->will($this->returnValue($formatterInstance));
        
        $sequenceStrategy = $this->getMock('IComeFromTheNet\Ledger\Voucher\Strategy\SequenceStrategyInterface');
        
        $strategyFactory->expects($this->once())
                        ->method('getInstance')
                        ->with($this->equalTo($data['voucher_sequence_strategy']),$this->equalTo($platform))
                        ->will($this->returnValue($sequenceStrategy));
        
        $builder = new VoucherBuilder($formatterBag,$strategyFactory,$bag,$platform);
        
        $voucher = $builder->build($data);
        
        $this->assertInstanceOf('IComeFromTheNet\Ledger\Voucher\VoucherEntity',$voucher);
        
        $this->assertSame($data['voucher_slug'],$voucher->getSlug());
        
        $this->assertSame($data['voucher_name'],$voucher->getName());
        
        $this->assertSame($data['voucher_description'],$voucher->getDescription());
        
        $this->assertSame($data['voucher_enabled_from'],$voucher->getEnabledFrom());
        
        $this->assertSame($data['voucher_enabled_to'],$voucher->getEnabledTo());
        
        $this->assertSame($data['voucher_prefix'],$voucher->getPrefix());
        
        $this->assertSame($data['voucher_suffix'],$voucher->getSuffix());
        
        $this->assertSame($data['voucher_maxlength'],$voucher->getMaxLength());
        
        $this->assertSame($data['voucher_sequence_padding_char'],$voucher->getPaddingChar());
        
        $this->assertEquals($formatterInstance,$voucher->getVoucherFormatter());
        
        $this->assertEquals($sequenceStrategy, $voucher->getSequenceStrategy());
        
        $this->assertEquals($bag,$voucher->getValidationRuleBag());
       
        
    }
    
    public function testDemolish()
    {
        $ruleBag = new ValidationRuleBag();
        
        $sequence = $this->getMock('IComeFromTheNet\Ledger\Voucher\Strategy\SequenceStrategyInterface');
        $formatter = $this->getMock('IComeFromTheNet\Ledger\Voucher\Formatter\FormatterInterface');
        
        $sequence->expects($this->once())
                ->method('getStrategyName')
                ->will($this->returnValue('uuid'));
        
        $formatter->expects($this->once())
                 ->method('getName')
                  ->will($this->returnValue('default'));
        
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
        
        $strategyFactory = $this->getMock('IComeFromTheNet\Ledger\Voucher\Strategy\StrategyFactoryInterface');
        $formatterBag    = $this->getMock('IComeFromTheNet\Ledger\Voucher\Formatter\FormatterBagInterface');
        $platform        = 'mysql';
        
        $builder = new VoucherBuilder($formatterBag,$strategyFactory,$ruleBag,$platform);
        
        $entity = new VoucherEntity();
        $entity->setSlug($voucherSlug);
        $entity->setName($voucherName);
        $entity->setDescription($voucherDescription);
        $entity->setEnabledFrom($voucherEnabledFrom);
        $entity->setEnabledTo($voucherEnabledTo);
        $entity->setPrefix($voucherPrefix);
        $entity->setSuffix($voucherSuffix);
        $entity->setMaxLength($voucherMaxLength);
        $entity->setPaddingChar($voucherPaddingChar);
        $entity->setVoucherFormatter($formatter);
        $entity->setSequenceStrategy($sequence);
        $entity->setValidationRuleBag($ruleBag);
        
        $data = $builder->demolish($entity);
        
        $this->assertEquals($data['voucher_slug'],$voucherSlug); 
        $this->assertEquals($data["voucher_enabled_from"],$voucherEnabledFrom );
        $this->assertEquals($data["voucher_enabled_to"],$voucherEnabledTo);
        $this->assertEquals($data['voucher_name'],$voucherName);
        $this->assertEquals($data['voucher_description'],$voucherDescription);
        $this->assertEquals($data['voucher_prefix'],$voucherPrefix);
        $this->assertEquals($data['voucher_suffix'],$voucherSuffix);
        $this->assertEquals($data['voucher_maxlength'],$voucherMaxLength);
        $this->assertEquals($data['voucher_formatter'],'default');
        $this->assertEquals($data['voucher_sequence_strategy'],'uuid');
        $this->assertEquals($data['voucher_sequence_padding_char'],$voucherPaddingChar);
        
        
                
    }
    
    
    
}
/* end of class */