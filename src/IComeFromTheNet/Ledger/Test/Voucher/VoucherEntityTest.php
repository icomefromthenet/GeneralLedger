<?php
namespace IComeFromTheNet\Ledger\Test\Voucher;

use DateTime;
use IComeFromTheNet\Ledger\Voucher\DB\VoucherGroup;
use IComeFromTheNet\Ledger\Voucher\DB\VoucherGenRule;

/**
  *  Test the Voucher Entity Object
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class VoucherEntityTest extends \PHPUnit_Framework_TestCase
{
    
    
    public function testVoucherGroupProperties()
    {
        
        $aGroup = new VoucherGroup();
        
        $sName = 'Sales Vouchers';
        $iID   = 1;
        $bDisabled = false;
        $iSort = 100;
        $oCreated = new DateTime();
        $sSlugName = 'sales_vouchers';
        
        $aGroup->setVoucherGroupID($iID);
        $this->assertEquals($iID,$aGroup->getVoucherGroupID());
        
        $aGroup->setDisabledStatus($bDisabled);
        $this->assertEquals($bDisabled,$aGroup->getDisabledStatus());
        
        $aGroup->setVoucherGroupName($sName);
        $this->assertEquals($sName,$aGroup->getVoucherGroupName());
        
        $aGroup->setSortOrder($iSort);
        $this->assertEquals($iSort,$aGroup->getSortOrder());
        
        $aGroup->setDateCreated($oCreated);
        $this->assertEquals($oCreated,$aGroup->getDateCreated());
        
        $aGroup->setSlugName($sSlugName);
        $this->assertEquals($sSlugName,$aGroup->getSlugName());
        
    }
    
    public function testVoucherGroupValidateSucessful()
    {
        $aGroup = new VoucherGroup();
        
        $sName = 'Sales Vouchers';
        $iID   = 1;
        $bDisabled = false;
        $iSort = 100;
        $oCreated = new DateTime();
        $sSlugName = 'sales_vouchers';
        //$sSlugName = '';
        
        $aGroup->setVoucherGroupID($iID);
        $aGroup->setDisabledStatus($bDisabled);
        $aGroup->setVoucherGroupName($sName);
        $aGroup->setSortOrder($iSort);
        $aGroup->setDateCreated($oCreated);
        $aGroup->setSlugName($sSlugName);
        
        $this->assertTrue($aGroup->validate());
        
        
        // test valid without ID (need create)
        $aGroup = new VoucherGroup();
        
        $sName = 'Sales Vouchers';
        $bDisabled = false;
        $iSort = 100;
        $oCreated = new DateTime();
        $sSlugName = 'sales_vouchers';
        
        
        $aGroup->setDisabledStatus($bDisabled);
        $aGroup->setVoucherGroupName($sName);
        $aGroup->setSortOrder($iSort);
        $aGroup->setDateCreated($oCreated);
        $aGroup->setSlugName($sSlugName);
        
        $this->assertTrue($aGroup->validate());
    }
    
     public function testVoucherGroupValidateFails()
    {
        $aGroup = new VoucherGroup();
        
        $sName = '';
        $iID   = null;
        $bDisabled = null;
        $iSort = 100;
        $oCreated = new DateTime();
        $sSlugName = '';
        
        
        $aGroup->setVoucherGroupID($iID);
        //$aGroup->setDisabledStatus($bDisabled);
        $aGroup->setVoucherGroupName($sName);
        $aGroup->setSortOrder($iSort);
        $aGroup->setDateCreated($oCreated);
        $aGroup->setSlugName($sSlugName);
        
        $aValidateErrors = $aGroup->validate(); 
        
        $this->assertEquals(count($aValidateErrors['slugName']),3);
        $this->assertEquals(count($aValidateErrors['name']),2);
        $this->assertEquals(count($aValidateErrors['isDisabled']),1);
        $this->assertEquals(count($aValidateErrors['voucherID']),1);
        
    }
    
    
    public function testVoucherRuleSuccess()
    {
        $oRule = new VoucherGenRule();
        
        $iVoucherGeneratorRuleId   = 1;
        $sVoucherRuleNameSlug      = 'rule_1';
        $sVoucherRuleName          = 'Rule 1';
        $sVoucherPaddingCharacter  = 'A'; 
        $sVoucherSuffix            = '###';
        $sVoucherPrefix            = '@@@';
        $iVoucherLength            = 10;
        $oDateCreated              = new DateTime();    
        $sSequenceStrategy         = 'UUID';
        
        
        $oRule->setVoucherGenRuleId($iVoucherGeneratorRuleId);
        $oRule->setSlugRuleName($sVoucherRuleNameSlug);
        $oRule->setVoucherRuleName($sVoucherRuleName);
        $oRule->setVoucherPaddingCharacter($sVoucherPaddingCharacter);
        $oRule->setVoucherSuffix($sVoucherSuffix);
        $oRule->setVoucherPrefix($sVoucherPrefix);
        $oRule->setVoucherLength($iVoucherLength);
        $oRule->setDateCreated($oDateCreated);
        $oRule->setSequenceStrategyName($sSequenceStrategy);
        
        $this->assertEquals($iVoucherGeneratorRuleId ,$oRule->getVoucherGenRuleId());
        $this->assertEquals($sVoucherRuleNameSlug,$oRule->getSlugRuleName());
        $this->assertEquals($sVoucherRuleName  ,$oRule->getVoucherRuleName());
        $this->assertEquals($sVoucherPaddingCharacter,$oRule->getVoucherPaddingCharacter());
        $this->assertEquals($sVoucherSuffix ,$oRule->getVoucherSuffix());
        $this->assertEquals($sVoucherPrefix ,$oRule->getVoucherPrefix());
        $this->assertEquals($iVoucherLength ,$oRule->getVoucherLength());
        $this->assertEquals($oDateCreated,$oRule->getDateCreated());
        $this->assertEquals($sSequenceStrategy ,$oRule->getSequenceStrategyName());
        
        
        $this->assertTrue($oRule->validate());
        
        # validate with no Database ID which be the case in INSERT
        $oRule = new VoucherGenRule();
        $oRule->setSlugRuleName($sVoucherRuleNameSlug);
        $oRule->setVoucherRuleName($sVoucherRuleName);
        $oRule->setVoucherPaddingCharacter($sVoucherPaddingCharacter);
        $oRule->setVoucherSuffix($sVoucherSuffix);
        $oRule->setVoucherPrefix($sVoucherPrefix);
        $oRule->setVoucherLength($iVoucherLength);
        $oRule->setDateCreated($oDateCreated);
        $oRule->setSequenceStrategyName($sSequenceStrategy);
     
        $this->assertTrue($oRule->validate());
        
        # valdiate with empty padding, suffix, prefix
        $oRule = new VoucherGenRule();
        $oRule->setSlugRuleName($sVoucherRuleNameSlug);
        $oRule->setVoucherRuleName($sVoucherRuleName);
        $oRule->setVoucherPaddingCharacter('');
        $oRule->setVoucherSuffix('');
        $oRule->setVoucherPrefix('');
        $oRule->setVoucherLength(100);
        $oRule->setDateCreated($oDateCreated);
        $oRule->setSequenceStrategyName($sSequenceStrategy);
        
        $this->assertTrue($oRule->validate());
    }
    
    // public function testEntityProperties()
    // {
    //     $ruleBag = new ValidationRuleBag();
    //     $ruleBag->addRule(new AlwaysValidRule());
        
    //     $sequence = $this->getMock('IComeFromTheNet\Ledger\Voucher\Strategy\SequenceStrategyInterface');
    //     $formatter = $this->getMock('IComeFromTheNet\Ledger\Voucher\Formatter\FormatterInterface');
        
    //     $voucherSlug        = 'invoice';
    //     $voucherName        = 'Invoice Journals';
    //     $voucherDescription = 'Voucher Description is for and invoice';
    //     $voucherEnabledFrom = new DateTime();
    //     $voucherEnabledTo   = new DateTime();
    //     $voucherEnabledTo->modify('+1 week');
    //     $voucherMaxLength   = 10;
    //     $voucherSuffix      = 'REF_';
    //     $voucherPrefix      = 'PRE_';
    //     $voucherPaddingChar = '@';
        
        
    //     $entity = new VoucherEntity();
        
    //     $entity->setSlug($voucherSlug);
    //     $this->assertSame($voucherSlug,$entity->getSlug());
        
    //     $entity->setName($voucherName);
    //     $this->assertSame($voucherName,$entity->getName());
        
    //     $entity->setDescription($voucherDescription);
    //     $this->assertSame($voucherDescription,$entity->getDescription());
        
    //     $entity->setEnabledFrom($voucherEnabledFrom);
    //     $this->assertSame($voucherEnabledFrom,$entity->getEnabledFrom());
        
    //     $entity->setEnabledTo($voucherEnabledTo);
    //     $this->assertSame($voucherEnabledTo,$entity->getEnabledTo());
        
    //     $entity->setPrefix($voucherPrefix);
    //     $this->assertSame($voucherPrefix,$entity->getPrefix());
        
    //     $entity->setSuffix($voucherSuffix);
    //     $this->assertSame($voucherSuffix,$entity->getSuffix());
        
    //     $entity->setMaxLength($voucherMaxLength);
    //     $this->assertSame($voucherMaxLength,$entity->getMaxLength());
        
    //     $entity->setPaddingChar($voucherPaddingChar);
    //     $this->assertSame($voucherPaddingChar,$entity->getPaddingChar());
        
    //     $entity->setVoucherFormatter($formatter);
    //     $this->assertEquals($formatter,$entity->getVoucherFormatter());
        
    //     $entity->setSequenceStrategy($sequence);
    //     $this->assertEquals($sequence, $entity->getSequenceStrategy());
        
    //     $entity->setValidationRuleBag($ruleBag);
    //     $this->assertEquals($ruleBag,$entity->getValidationRuleBag());
        
    // }
    
    
    // /**
    // *  @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
    // *  @expectedExceptionMessage Date the voucher becomes available must occur before the assigned unavailable date
    // */
    // public function testSetEnabledFromErrorWhenOccursAfterEnabedTo()
    // {
    //     $voucherEnabledFrom = new DateTime();
    //     $voucherEnabledTo   = new DateTime();
    //     $voucherEnabledTo->modify('-1 week');
        
    //     $entity = new VoucherEntity();
        
    //     $entity->setEnabledTo($voucherEnabledTo);
    //     $entity->setEnabledFrom($voucherEnabledFrom);
        
    // }
    
    // /**
    // *  @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
    // *  @expectedExceptionMessage Date the voucher becomes unavailable must occur after the assigned available date
    // */
    // public function testSetEnabledToErrorWhenOccursBeforeEnableFrom()
    // {
        
    //     $voucherEnabledFrom = new DateTime();
    //     $voucherEnabledTo   = new DateTime();
    //     $voucherEnabledTo->modify('-1 week');
        
    //     $entity = new VoucherEntity();
        
    //     $entity->setEnabledFrom($voucherEnabledFrom);
    //     $entity->setEnabledTo($voucherEnabledTo);
        
        
    // }
    
    // /**
    // *  @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
    // *  @expectedExceptionMessage Voucher name must not be empty
    // */
    // public function testErrorWhenSettingEmptyName()
    // {
    //     $entity = new VoucherEntity();
    //     $entity->setName(null);
    // }
    
    // /**
    // *  @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
    // *  @expectedExceptionMessage Voucher slug must not be empty
    // */
    // public function testErrorWhenSettingEmptySlug()
    // {
    //     $entity = new VoucherEntity();
    //     $entity->setSlug(null);
    // }
    
    
    // public function testValidateRuleBag()
    // {
        
    //     $alwaysValidBag = new ValidationRuleBag();
    //     $alwaysValidBag->addRule(new AlwaysValidRule());
        
    //     $alwaysInvalidBag = new ValidationRuleBag();
    //     $alwaysInvalidBag->addRule(new AlwaysInvalidRule());
        
    //     $entity = new VoucherEntity();
    //     $entity->setValidationRuleBag($alwaysValidBag);
    //     $this->assertTrue($entity->validateReference('b'));
       
    //     $entity = new VoucherEntity();
    //     $entity->setValidationRuleBag($alwaysInvalidBag);
    //     $this->assertFalse($entity->validateReference('a'));
    // }
    
    
    // public function testGenerateReferenceWithMocks()
    // {
    //           $ruleBag = new ValidationRuleBag();
    //     $ruleBag->addRule(new AlwaysValidRule());
        
    //     $sequence = $this->getMock('IComeFromTheNet\Ledger\Voucher\Strategy\SequenceStrategyInterface');
        
    //     $sequence->expects($this->once())
    //              ->method('nextVal')
    //              ->with($this->equalTo('invoice'))
    //              ->will($this->returnValue(1));
        
    //     $formatter = $this->getMock('IComeFromTheNet\Ledger\Voucher\Formatter\FormatterInterface');
        
    //     $formatter->expects($this->once())
    //               ->method('format')
    //               ->with($this->equalTo(1))
    //               ->will($this->returnValue('REF_1'));
        
    //     $entity = new VoucherEntity();
        
    //     $entity->setVoucherFormatter($formatter);
    //     $this->assertEquals($formatter,$entity->getVoucherFormatter());
        
    //     $entity->setSequenceStrategy($sequence);
    //     $this->assertEquals($sequence, $entity->getSequenceStrategy());
        
    //     $entity->setValidationRuleBag($ruleBag);
    //     $this->assertEquals($ruleBag,$entity->getValidationRuleBag());
        
    //     $entity->setSlug('invoice');
        
    //     $this->assertEquals('REF_1',$entity->generateReference());
        
    // }
    
    // /**
    //  *  @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
    //  *  @expectedExceptionMessage Generated reference failed to validate, maybe sequence is broken
    //  * 
    //  */
    // public function testGenerateReferenceWithMocksFailsValidate()
    // {
    //     $ruleBag = new ValidationRuleBag();
    //     $ruleBag->addRule(new AlwaysInvalidRule());
        
    //     $sequence = $this->getMock('IComeFromTheNet\Ledger\Voucher\Strategy\SequenceStrategyInterface');
        
    //     $sequence->expects($this->once())
    //              ->method('nextVal')
    //              ->with($this->equalTo('invoice'))
    //              ->will($this->returnValue(1));
        
    //     $formatter = $this->getMock('IComeFromTheNet\Ledger\Voucher\Formatter\FormatterInterface');
        
    //     $formatter->expects($this->once())
    //               ->method('format')
    //               ->with($this->equalTo(1))
    //               ->will($this->returnValue('REF_1'));
        
    //     $entity = new VoucherEntity();
        
    //     $entity->setVoucherFormatter($formatter);
    //     $this->assertEquals($formatter,$entity->getVoucherFormatter());
        
    //     $entity->setSequenceStrategy($sequence);
    //     $this->assertEquals($sequence, $entity->getSequenceStrategy());
        
    //     $entity->setValidationRuleBag($ruleBag);
    //     $this->assertEquals($ruleBag,$entity->getValidationRuleBag());
        
    //     $entity->setSlug('invoice');
        
    //     $entity->generateReference();
        
    // }
    
}