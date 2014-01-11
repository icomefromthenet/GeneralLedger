<?php
namespace IComeFromTheNet\Ledger\Test;

use IComeFromTheNet\Ledger\Test\Base\TestWithContainer;
use IComeFromTheNet\Ledger\Voucher\ValidationRuleBag;
use IComeFromTheNet\Ledger\Voucher\Rule\AlwaysValidRule;
use IComeFromTheNet\Ledger\Voucher\Rule\AlwaysInvalidRule;
use IComeFromTheNet\Ledger\Voucher\Strategy\SequenceStrategyInterface;
use IComeFromTheNet\Ledger\Voucher\Formatter\FormatterInterface;

/**
  *  Test the Voucher Entity Object
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class VoucherEntityBagTest extends TestWithContainer
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
        
    }
    
    
    
}