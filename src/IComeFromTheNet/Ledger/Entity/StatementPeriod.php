<?php
namespace IComeFromTheNet\Ledger\Entity;

use IComeFromTheNet\Ledger\Exception\LedgerException;
use Aura\Marshal\Entity\GenericEntity;

/**
  *  A period definition for a trial balance statement
  *
  *  Example periods include 60 days,90 days,120 days, 1 year
  *
  *  Min unit is 1 day, a period can be disabled to prevent its use
  * 
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class StatementPeriod extends GenericEntity
{
    const FIELD_STATEMENT_PERIOD_ID     = 'statement_period_id';
    const FIELD_UNITS                   = 'period_units';
    const FIELD_NAME                    = 'period_name';
    const FIELD_DESCRIPTION             = 'period_description';
    const FIELD_ENABLED_FROM            = 'period_enabled_from';
    const FIELD_ENABLED_TO              = 'period_enabled_to';
    
    
    /**
     *  Class Constructor
     *
     *  @access public
     *  @return void
     *
    */
    public function __construct()
    {
            $this->__set(self::FIELD_DESCRIPTION,null);
            $this->__set(self::FIELD_STATEMENT_PERIOD_ID,null);
            $this->__set(self::FIELD_ENABLED_FROM,null);
            $this->__set(self::FIELD_ENABLED_TO,null);
            $this->__set(self::FIELD_NAME,null);
            $this->__set(self::FIELD_UNITS,null);
    }
    
    
    /**
     *  Return the Database Id
     *
     *  @access public
     *  @return integer the db id
     *
    */
    public function getStatementPeriodID()
    {
        return $this->__get(self::FIELD_STATEMENT_PERIOD_ID);
    }
    
    /**
     *  Set the statement period database ID
     *
     *  @access public
     *  @return void
     *
    */
    public function setStatementPeriodID($id)
    {
        if(is_int($id) === false) {
            throw new LedgerException('Statement Period id must be an integer');
        }
        
        if($id <= 0) {
            throw new LedgerException('Statement Period id must be an integer > 0');
        }
        
        $this->__set(self::FIELD_STATEMENT_PERIOD_ID,$id);
    }
    
    /**
     *  Fetch the number of days in period
     *
     *  @access public
     *  @return integer the number of days (units)
     *
    */
    public function getPeriodUnits()
    {
        return $this->__get(self::FIELD_UNITS);
    }
    
    
    /**
     *  Sets the number of units
     *
     *  @access public
     *  @return $units
     *
    */
    public function setPeriodUnits($units)
    {
        if(is_int($units) === false) {
            throw new LedgerException('Statement Period units must be an integer');
        }
        
        if($units <= 0) {
            throw new LedgerException('Statement Period units must be an integer > 0');
        }
        
        $this->__set(self::FIELD_UNITS , $units);
    }
    
    /**
     *  Gets the name of this period
     *
     *  @access public
     *  @return string the name of this period 50 characters max
     *
    */
    public function getPeriodName()
    {
        return $this->__get(self::FIELD_NAME);
    }
    
    /**
     *  Sets the name of the period max 50 characters
     *
     *  @access public
     *  @return void
     *  @param string @period
     *
    */
    public function setName($name)
    {
        if(!is_string($name)) {
            throw new LedgerException('Statement Period name must be a string');
        }
        
        if(mb_strlen($name) > 50 OR mb_strlen($name) <= 0) {
            throw new LedgerException('Statement Period name must be between 1 and 50 characters');
        }
        
        $this->__set(self::FIELD_NAME,$name);
    }
    
    /**
     *  Sets the Periods Description
     *
     *  @access public
     *  @return string the periods description max 255 characters
     *
    */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     *  Set a description of this period limit of 255 characters
     *
     *  e.g 120 day outstanding statement
     *
     *  @access public
     *  @return void
     *  @param string $description of 255 characters less
     *
    */
    public function setDescription($description)
    {
        
        if(!is_string($description)) {
            throw new LedgerException('Statement Period description must be a string');
        }
        
        if(mb_strlen($description) > 255 OR mb_strlen($description) <= 0) {
            throw new LedgerException('Statement Period description must be between 1 and 255 characters');
        }
        
        $this->__set(self::FIELD_DESCRIPTION,$description);
    }
    
    /**
     *  Fetch if this period is enabled for a trial balance     
     *
     *  @access public
     *  @return DateTime the enabled from date
     *
    */
    public function getEnabledFrom()
    {
        return $this->__get(self::FIELD_ENABLED_FROM);
    }
    
    /**
     *  Set if the date the period is enabled for trial balances
     *
     *  @access public
     *  @return void
     *  @param DateTime $enabled
     *
    */
    public function setEnabledFrom(DateTime $enabled)
    {
         $closed = $this->__get(self::FIELD_ENABLED_TO);
        
        if($closed instanceof DateTime) {
            if($closed <= $enabled) {
                throw new LedgerException('The statement period min date from must be before the max date');
            }
        }
        
        $this->__set(self::FIELD_ENABLED_FROM,$enabled);
    }
    
    /**
     *   Gets the max date the period is available
     *
     *  @access public
     *  @return DateTime
     *
    */
    public function getEnabledTo()
    {
        return $this->__get(self::FIELD_ENABLED_TO);
    }
    
    /**
     *  Sets the max date the period is available
     *
     *  @access public
     *  @return void
     *  @param DateTime $to
     *
    */
    public function setEnabledTo(DateTime $to)
    {
        $opened = $this->__get(self::FIELD_ENABLED_FROM);
        
        if($opened instanceof DateTime) {
            if($opened >= $to) {
                throw new LedgerException('The statement period max date must be after the min date');
            }
        }
        
        $this->__set(self::FIELD_ENABLED_TO,$to);
        
    }
    
}
/* End of Class */
