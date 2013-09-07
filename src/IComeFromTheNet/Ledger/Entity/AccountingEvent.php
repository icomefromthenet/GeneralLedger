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
    
    // ---------------------------------------------------------------------
    # meta details
    
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
    
    

    /**
     *  Class Constructor
     *
     *  @access public
     *  @return void
     *
    */
    public function __construct(DateTime $dateOccured,
                                Datetime $dateNoticed,
                                $eventType,
                                $memorandum,
                                $amount)
    {
        $this->setOccuredDate($dateOccured);
        $this->setNoticedDate($dateNoticed);
        $this->setEventType($eventType);
        $this->setMemorandum($memorandum);
        $this->setAmount($amount);
        
    }
    
    
    // -------------------------------------------------------------------------
    # Protected Setters, Since Events can not be changed once committed, these
    # setters exist to hold validation logic and used in the constructor
    
    protected function setOccuredDate(DateTime $occured)
    {
        $this->dateOccured = $occrued;
    }
    
    protected function setNoticedDate(DateTime $noticed)
    {
        $this->dateNoticed = $noticed;
    }
    
    protected function setMemorandum($data)
    {
        $this->memorandum = $data;
    }
    
    protected function setEventType($type)
    {
        if(empty($type)) {
            throw new LedgerException('eventType must not be empty');
        }
        
        $this->eventType = $type;
    }
    
    protected function setAmount($amt)
    {
        if(!is_numeric($amt)) {
            throw new LedgerException('Amount must be numeric');
        }
        $this->amount = $amt;
    }
    
     /**
     *  Set the events storage id
     *
     *  @access public
     *  @return void
     *  @param integer $id
     *
    */
    public function setEventId($id)
    {
        if(!is_init($id) || (integer) $id < 0) {
            throw new LedgerException('Event ID must be an integer > 0');
        }
        
        $this->eventID = $id;
    }
    
    
    
    // -------------------------------------------------------------------------
    # Accessors
    
    /**
     *  Fetch the events storage id
     *
     *  @access public
     *  @return integer the events storage id
     *
    */
    public function getEventId()
    {
        return $this->eventID;
    }
    
   
    /**
     *  Fetch the date the event occured on
     *
     *  @access public
     *  @return DateTime
     *
    */
    public function getOccuredDate()
    {
        return $this->dateOccured;
    }
    
    /**
     *  Fetch the date the event was noticed (processed)
     *
     *  @access public
     *  @return DateTime
     *
    */   
    public function getNoticedDate()
    {
        return $this->dateNoticed;        
    }
    
    /**
     *  Fetch the event type descriptor
     *
     *  @access public
     *  @return string the eventType name
     *
    */
    public function getEventType()
    {
        return $this->eventType;
    }
    
    /**
     *  Fetch the amount the event
     *
     *  @access public
     *  @return double
     *
    */
    public function getAmount()
    {
        return $this->amount;
    }
    
    /**
     *  Fetch the memorandum data
     *
     *  @access public
     *  @return mixed
     *
    */
    public function getMemorandum()
    {
        return $this->memorandum;
    }
    
    
    # ------------------------------------------------------------------
    
    
    /**
     *  Has this entity been stored, or is it only in memeory
     *  if it has been assigned and eventID must be stored.
     *
     *  @access public
     *  @return boolean true if stored
     *
    */
    public function stored()
    {
        return ($this->eventID !== null) ? true : false;
    }
    
}
/* End of File */