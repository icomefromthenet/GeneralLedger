<?php
namespace IComeFromTheNet\Ledger\Event\Voucher;

/**
  *  List of events that used in the voucher component
  *  
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
final class VoucherEvents
{
    /**
     * The icomefromthenet.ledger.voucher.sequence.before event is raised before a sequnce is fetched from database
     *
     * @var string
     */
    const SEQUENCE_BEFORE = 'icomefromthenet.ledger.voucher.sequence.before';
    
    /**
     * The icomefromthenet.ledger.voucher.sequence.after event is raised after a sequnce is fetched from database
     *
     * @var string
     */
    const SEQUENCE_AFTER = 'icomefromthenet.ledger.voucher.sequence.after';
    
    /**
     * The icomefromthenet.ledger.voucher.sequence.strategy.instanced' event is raised after a sequnce strategy is instanced
     *
     * @var string
     */
    const SEQUNENCE_STRATEGY_INSTANCED = 'icomefromthenet.ledger.voucher.sequence.strategy.instanced';
    
    /**
     * The icomefromthenet.ledger.voucher.strategy.registered event is raised after a sequence strategy is registered with factory
     *
     * @var string
     */
    const SEQUENCE_STRATEGY_REGISTERED = 'icomefromthenet.ledger.voucher.sequence.strategy.registered';
    
    /**
     * The icomefromthenet.ledger.voucher.sequence.driver.instanced event is raised after a sequnce driver is instanced
     *
     * @var string
     */
    const SEQUNENCE_DRIVER_INSTANCED = 'icomefromthenet.ledger.voucher.sequence.driver.instanced';
    
    /**
     * The icomefromthenet.ledger.voucher.driver.registered event is raised after a sequence driver is registered with factory
     *
     * @var string
     */
    const SEQUENCE_DRIVER_REGISTERED = 'icomefromthenet.ledger.voucher.sequence.driver.registered';
    
    
}