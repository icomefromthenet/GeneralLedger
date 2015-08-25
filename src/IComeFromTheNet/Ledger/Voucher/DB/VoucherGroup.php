<?php
namespace IComeFromTheNet\Ledger\Voucher\DB;

use \DateTime;
use Valitron\Validator;

class VoucherGroup
{
    
    protected $voucherID;
    protected $name;
    protected $dteCreated;
    protected $sortOrder;
    protected $isDisabled;
    protected $slugName;
    
    /**
     * Fetch the vouchers group database id
     * 
     * @return integer the database id
     */ 
    public function getVoucherGroupID()
    {
        return $this->voucherID;
    }
    
    /**
     * Set the Group Database ID
     * 
     * @param   integer $id The database id
     * @return  void
     */ 
    public function setVoucherGroupID($id)
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
    public function getVoucherGroupName()
    {
        return $this->name;
    }
    
    /**
     * Sets the name of the group
     * 
     * @param   string  $name   the human name
     * @return  void
     */ 
    public function setVoucherGroupName($name)
    {
        $this->name = (string) $name;
    }
    
    /**
     * Returns a slug version of group name
     * 
     * @return string slug name
     * 
     */ 
    public function getSlugName()
    {
        return $this->slugName;
    }
    
    /**
     * Sets the slug version of the name
     * 
     * @access public
     * @param string    $slugName   The slug version of group name
     * @return void
     */ 
    public function setSlugName($slugName)
    {
        $this->slugName = (string) $slugName;
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
    
    /**
     * Sets the assigned time this group was created
     * The value is assigned by the database
     * 
     * @param   DateTime  $created  The creation date assigne by database
     */ 
    public function setDateCreated(DateTime $created)
    {
        return $this->dteCreated = $created;
    }
    
    /**
     * Validates if the assign properties are valid for a
     * database insert
     * 
     * @return boolean true if 
     */ 
    public function validate()
    {
        
        $aFields = array(
           'voucherID'  => $this->getVoucherGroupID()
          ,'name'       => $this->getVoucherGroupName()
          ,'sortOrder'  => $this->getSortOrder()
          ,'isDisabled' => $this->getDisabledStatus()
          ,'slugName'   => $this->getSlugName()
            
        );
        
        $v = new Validator($aFields);
        
        $v->rule('slug', 'slugName');
        $v->rule('lengthBetween',array('slugName','name'),1,100);
        $v->rule('required',array('slugName','name','isDisabled'));
        $v->rule('min',array('voucherID'),1);
        
        if($v->validate()) {
            return true;
        } else {
            return $v->errors();
        }
       
    }
    
    
}
/* End of Class */
