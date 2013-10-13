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
    
    
    
    public function getStatementPeriodID()
    {
        
    }
    
    public function setStatementPeriodID($id)
    {
        
    }
    
    
    public function getPeriodUnits()
    {
        
    }
    
    
    public function setPeriodUnits($units)
    {
        
    }
    
    
    public function getName()
    {
        
    }
    
    public function setName($name)
    {
        
    }
    
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
