<?php
namespace IComeFromTheNet\Ledger\Voucher\DB;

use \DateTime;



class VoucherGroup
{
    
    protected $voucherID;
    protected $name;
    protected $dteCreated;
    protected $sortOrder;
    protected $isDisabled;
    
    /**
     * Fetch the vouchers group database id
     * 
     * @return integer the database id
     */ 
    public function getID()
    {
        return $this->voucherID;
    }
    
    /**
     * Set the Group Database ID
     * 
     * @param   integer $id The database id
     * @return  void
     */ 
    public function setID($id)
    {
        $this->voucherID = (integer) $id;
    }
    
    /**
     * Is this group disabled
     * 
     * @return boolean true if disabled
     */ 
    public function getDisabledStatus()
    {
       return $this->isDisabled; 
    }
    
    /**
     * Sets the disabled status of this group
     * 
     * @param   boolean $isDisabled The disabled status of this group
     * @return  void
     */ 
    public function setDisabledStatus($isDisabled)
    {
        $this->isDisabled =  (boolean) $isDisabled;
    }
    
    /**
     * Returns the human name of this group
     * 
     * @return   string the human name of group
     */ 
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Sets the name of the group
     * 
     * @param   string  $name   the human name
     * @return  void
     */ 
    public function setName($name)
    {
        $this->name = (string) $name;
    }
    
    
    /**
     * Get the sort order for this group
     * 
     * @return integer the sort order
     */ 
    public function getSortOrder()
    {
        return $this->sortOrder;
    }
    
    /**
     * Sets the sort order for this group
     * 
     * @param integer   $iOrder A value to sort this group within a list
     */ 
    public function setSortOrder($iOrder)
    {
        $this->sortOrder = (integer) $iOrder;
    }
    
    
    /**
     * Fetches the assigned time this group was created
     * The value is assigned by the database
     * 
     * @return DateTime the creation date
     */ 
    public function getDateCreated()
    {
        return $this->dteCreated;
    }
    

    
    public function validate()
    {
        
        
    }
    
    
}
/* End of Class */
