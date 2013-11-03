<?php
namespace IComeFromTheNet\Ledger\Entity;

use DateTime;
use IComeFromTheNet\Ledger\Exception\LedgerException;

/**
  *  Represent a Organisation Unit, these units are used
  *  to provide logical groups to ledger transactions.
  *
  *  Accounts track the what , organisation unit can track to who.
  *
  *  Like accounts and statement periods, organisation units have a
  *  validity period but are never removed once committed.
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class OrganisationUnit
{
    
    protected $organisationUnitID;
    
    protected $organisationName;
    
    protected $validFrom;
    
    protected $validTo;
    
    
    
    /**
     *  Get the database identifer for this organisation unit   
     *
     *  @access public
     *  @return integer the database id
     *
    */
    public function getOrganisationUnitID()
    {
        return $this->organisationUnitID;
    }
    
    /**
     *  Sets the database if for this organisation unit
     *
     *  @access public
     *  @return void
     *  @param integer $id the database identifier
     *  @throws LedgerException when the param is not an integer or < 0
     *
    */
    public function setOrganisationUnitID($id)
    {
        if(!is_int($id)) {
            throw new LedgerException('Organisation Unit ID must be an integer');
        }
        
        if($id <= 0) {
            throw new LedgerException('Organisation Unit ID must be an integer > 0');
        }
        
        $this->organisationUnitID = $id;
    }
    
    /**
     *  Gets the name for this organisation unit
     *
     *  @access public
     *  @return string the orgainisations name
     *
    */
    public function getOrganisationName()
    {
        return $this->organisationName;
    }
    
    /**
     *  Set a name for this organisation unit
     *
     *  @access public
     *  @return void
     *  @param string $name max length 50
     *
    */
    public function setOrganisationName($name)
    {
        if(!is_string($name) OR empty($name)) {
            throw new LedgerException('Organisation Unit name must me a non empty string');
        }
        
        if(mb_strlen($name) > 50) {
             throw new LedgerException('Organisation Unit name must me a non empty string > 0 and <= 50 characters');
        }
        
        
        $this->organisationName = $name;
    }
    
    /**
     *  Returns the minimum validity date   
     *
     *  @access public
     *  @return DateTime the min validity date
     *
    */
    public function getValidFrom()
    {
        return $this->validFrom;  
    }
    
    /**
     *  Sets the minimum validity date  
     *
     *  @access public
     *  @return void
     *  @param Datetime $validFrom the min validity date
     *  @throws LedgerException when param date occurs after the max validity date
     *
    */
    public function setValidFrom(DateTime $validFrom)
    {
         if($this->validTo instanceof DateTime) {
            
            if($validFrom > $this->validTo) {
                throw new LedgerException('Organisation Unit valid from date must occur before the valid to date');
            }
            
        }
        
        $this->validFrom = $validFrom;
    }
    
    /**
     *  Returns the maximum validity date   
     *
     *  @access public
     *  @return DateTime the max validity date
     *
    */
    public function getValidTo()
    {
        return $this->validTo;
    }
    
    /**
     *  Sets the max validity date
     *
     *  @access public
     *  @return void
     *  @param DateTime $validTo the max valid date
     *  @throws LedgerException when param date occurs before the min validity date
     *
    */
    public function setValidTo(DateTime $validTo)
    {
        if($this->validFrom instanceof DateTime) {
            
            if($validTo < $this->validFrom) {
                throw new LedgerException('Organisation Unit valid to date must occur after the valid from date');
            }
            
        }
        
        $this->validTo = $validTo;
    }
    
}
/* End of Class */
