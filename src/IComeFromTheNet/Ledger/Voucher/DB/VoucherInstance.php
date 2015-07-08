<?php
namespace IComeFromTheNet\Ledger\Voucher\DB;

use Valitron\Validator;
use \DateTime;

/**
 * A Entity for the Voucher Instances
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0.0
 */ 
class VoucherInstance
{
    /**
     * @var integer the database instance table id
     */ 
    protected $iVoucherInstanceId;
    
    /**
     * @var integer the database id of the voucher type this an instance of
     */ 
    protected $iVoucherTypeId;
    
    /**
     * @var string the unique voucher number that belongs to this instance
     */ 
    protected $sVoucherCode;
    
    /**
     * @var DateTime when this instance was created
     */ 
    protected $oDateCreated;
    
    /**
     * Fetch the database id of this instance 
     * 
     * @return integer the database id 
     * @access public
     */ 
    public function getVoucherInstanceId()
    {
        return $this->iVoucherInstanceId;
    }
    
    /**
     * Sets the database id
     * 
     * @param integer   $iVoucherInstanceId the database id
     * @return void
     * @access public
     */ 
    public function setVoucherInstanceId($iVoucherInstanceId)
    {
        $this->iVoucherInstanceId = (int) $iVoucherInstanceId;
    }
    
    /**
     * Gets the database this instance belongs
     * 
     * @access public
     * @return integer The voucher type this instance belong too.
     */ 
    public function getVoucherTypeId()
    {
        return $this->iVoucherTypeId;
    }
    
    /**
     * Sets the database this instance belongs
     * 
     * @access public
     * @return void
     * @param $iVoucherTypeId   The voucher type this instance belong too.
     */ 
    public function setVoucherTypeId($iVoucherTypeId)
    {
        $this->iVoucherTypeId = (int) $iVoucherTypeId;
    }
    
    /**
     * Sets the unique voucher number that was generated
     * 
     * @return string the unique voucher number
     */ 
    public function getVoucherCode()
    {
        return $this->sVoucherCode;
    }
    
    /**
     * Fetches the unique voucher number that was generated
     * 
     * @access public
     * @return void
     * @param string $sVoucherCode the unique generated value
     */ 
    public function setVoucherCode($sVoucherCode)
    {
        $this->sVoucherCode = (string) $sVoucherCode;
    }
    
    /**
     * Gets the date this instance was generated/created this may not be same
     * as the processing date
     * 
     * @return DateTime when this entity was created
     */ 
    public function getDateCreated()
    {
        return $this->oDateCreated;
    }
    
    /**
     * Sets the date this entity was created/generated,  this may not be same
     * as the processing date
     * 
     * @param DateTime $oCreated    When this instance was generated
     * @return void
     * @access public
     */ 
    public function setDateCreated(DateTime $oCreated)
    {
        $this->oDateCreated = $oCreated;
    }
    
    
    
    
}
/* End of Class */