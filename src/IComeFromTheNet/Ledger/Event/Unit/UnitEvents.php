<?php
namespace IComeFromTheNet\Ledger\Event\Unit;

/**
  *  List of events that used during Unit of Work Execution
  *  
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
final class UnitEvents
{
    /**
     * The icomefromthenet.ledger.unit.committed event is raised when unit has been committed to database
     *
     * @var string
     */
    const EVENT_COMMITTED = 'icomefromthenet.ledger.unit.committed';
    
 
    /**
     * The icomefromthenet.ledger.unit.rollback event is raised when unit has errored and rolledback
     *
     * @var string
     */
    const EVENT_ROLLBACK = 'icomefromthenet.ledger.unit.rollback';
    
    
    /**
     * The icomefromthenet.ledger.unit.start event is raised when unit has started a transaction
     *
     * @var string
     */
    const EVENT_START = 'icomefromthenet.ledger.unit.start';
    
    
    /**
     * The icomefromthenet.ledger.unit.processing.finish event is raised when unit has finished processing its work and committed result
     *
     * @var string
     */
    const EVENT_PROCESSING_FINISH = 'icomefromthenet.ledger.unit.processing.finish';
    
    /**
     * The icomefromthenet.ledger.unit.processing.errorevent is raised when unit can not finish work and rolledback
     *
     * @var string
     */
    const EVENT_PROCESSING_ERROR = 'icomefromthenet.ledger.unit.processing.error';
    
    
     /**
     * The icomefromthenet.ledger.unit.processing.start event is raised when unit started processing before transaction opened
     *
     * @var string
     */
    const EVENT_PROCESSING_START = 'icomefromthenet.ledger.unit.processing.start';
    
}