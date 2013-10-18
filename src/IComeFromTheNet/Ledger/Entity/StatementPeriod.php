<?php
namespace IComeFromTheNet\Ledger\Entity;

use IComeFromTheNet\Ledger\Exception\LedgerException;


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
class StatementPeriod
{
    protected $statementPeriodID;
    
    protected $units;
    
    protected $name;
    
    protected $description;
    
    protected $enabled;
    
    
    /**
     *  Class Constructor
     *
     *  @access public
     *  @return void
     *
    */
    public function __construct()
    {
            $this->enabled = true;
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
        return $this->statementPeriodID;
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
        if(is_init($id) === false) {
            throw new LedgerException('Statement Period id must be an integer');
        }
        
        if($id <= 0) {
            throw new LedgerException('Statement Period id must be an integer > 0');
        }
        
        $this->statementPeriodID = $id;
    }
    
    /**
     *  Fetch the number of days in period
     *
     *  @access public
     *  @return integer the number of days (units)
     *
    */
    public function getUnits()
    {
        return $this->units;
    }
    
    
    /**
     *  Sets the number of units
     *
     *  @access public
     *  @return $units
     *
    */
    public function setUnits($units)
    {
        if(is_init($units) === false) {
            throw new LedgerException('Statement Period units must be an integer');
        }
        
        if($units <= 0) {
            throw new LedgerException('Statement Period units must be an integer > 0');
        }
        
        $this->units = $units;
    }
    
    /**
     *  Gets the name of this period
     *
     *  @access public
     *  @return string the name of this period 50 characters max
     *
    */
    public function getName()
    {
        return $this->name;
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
        
        $this->name = $name;
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
        
        $this->description = $description;
    }
    
    /**
     *  Fetch if this period is enabled for a trial balance     
     *
     *  @access public
     *  @return boolean true if enabled 
     *
    */
    public function getEnabled()
    {
        return $this->enabled;
    }
    
    /**
     *  Set if the period is enabled for trial balances
     *
     *  @access public
     *  @return void
     *  @param boolean $enabled
     *
    */
    public function setEnabled($enabled)
    {
        if(!is_bool($enabled)) {
            throw new LedgerException('Statement Period enabled flag must be a boolean');
        }
        
        
        $this->enabled = (boolean) $enabled;
    }
    
}
/* End of Class */
