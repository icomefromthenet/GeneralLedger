<?php
namespace IComeFromTheNet\Ledger\Entity;

use DateTime;

/**
  *  AccountingEvent Entity
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class AccountingEvent
{
    
    /*
     * @var integer the store ID
     */
    protected $eventID;
       
    /*
     * @var DateTime when the event occured outside the system
     *      can match date noticed and processed, if occurs at
     *      same time. 
     */
    protected $dateOccured;
    
    /*
     * @var DateTime when the event was recorded
     */
    protected $dateNoticed;
    
    // meta details
    
    /*
     * @var used in rules processing could be a rule, name, a generic description
     */
    protected $eventType;
    
    /*
     * @var properties available to rules engine but not indexed in the store
     *      serialized within and an array here
     */
    protected $memorandum;
    
    /*
     * @var double monetary value of the event
     *      note not signed. Credit/Debit based on context
     */
    protected $amount;
    
    
    // Event Processing Info
    
    /*
     * @var DateTime Processed date 
     */
    protected $dateProcessed;
    
    /*
     * @var boolean True if event has been processed and added to GL
     */
    protected $isProcessed;
    
    
    
    
    // Reversal Properties
    /*
     * @var boolean has this event been reversed with another event
     */
    protected $hasBeenReversed;
    
    /*
     * @var integer the Store ID of the reversal Event
     */
    protected $reversalID;
    
    // Adjustent details
    
    /*
     * @var boolean is this event an adjustemnt
     */
    protected $isAdjustment;
    
    protected $adjustedEventID;
    
}
/* End of File */