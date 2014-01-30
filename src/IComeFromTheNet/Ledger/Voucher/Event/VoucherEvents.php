<?php
namespace IComeFromTheNet\Ledger\Voucher\Event;

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
    
    
    /**
     * The icomefromthenet.ledger.voucher.created event is raised after a voucher first stored
     *
     * @var string
     */
    const voucher_created = 'icomefromthenet.ledger.voucher.created';
    
    /**
     * The icomefromthenet.ledger.voucher.unexpired event is raised after a voucher has expiry date set range
     *
     * @var string
     */
    const voucher_expired = 'icomefromthenet.ledger.voucher.expired';
    
    /**
     * The icomefromthenet.ledger.voucher.driver.registered event is raised after a voucher has expire date range changed to future
     *
     * @var string
     */ 
    const voucher_unexpired = 'icomefromthenet.ledger.voucher.unexpired';
    
    /**
     * The 'icomefromthenet.ledger.voucher.modified' event is raised after a new voucher version saved 
     *
     * @var string
     */
    const voucher_modified = 'icomefromthenet.ledger.voucher.modified';
    
}