<?php
namespace IComeFromTheNet\Ledger\Entity;

use Aura\Marshal\Entity\GenericEntity;
use IComeFromTheNet\Ledger\Exception\LedgerException;

/**
  *  Represent a custom Ledger Entry type.
  *
  *  Ledger transaction are often divied into groups, for example
  *
  *  1. General Journals
  *  2. Sales Recepits
  *  3. Invoices
  *  4. etc
  *
  *  As we can't know every group (voucher type) this entity allows
  *  developers to define their own and relate them back to a ledger transaction
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class VoucherTypes extends GenericEntity
{
    const DESCRIPTION_MAX_SIZE  = 500;
    const NAME_MAX_SIZE         = 100;
    
    
    const FIELD_VOUCHER_TYPE_ID = 'voucher_type_id';
    const FIELD_NAME            = 'voucher_name';
    const FIELD_DESCRIPTION     = 'voucher_description';
    const FIELD_ENABLE_FROM     = 'voucher_enable_from';
    const FIELD_ENABLE_TO       = 'voucher_enable_to';
    
    
    
    public function __construct()
    {
        $this->__set(self::FIELD_VOUCHER_TYPE_ID,null);
        $this->__set(self::FIELD_NAME,null);
        $this->__set(self::FIELD_DESCRIPTION,null);
        $this->__set(self::FIELD_ENABLE_FROM,null);
        $this->__set(self::FIELD_ENABLE_TO,null);
        
    }
    
    
    /**
     *  docs
     *
     *  @access public
     *  @return void
     *
    */
    public function getVoucherTypeID()
    {
        return $this->__get(self::FIELD_VOUCHER_TYPE_ID);
    }
    
    /**
     *  docs
     *
     *  @access public
     *  @return void
     *
    */
    public function setVoucherTypeID($id)
    {
        if(!is_init($id) || (int) $id <= 0) {
            throw new LedgerException('Voucher type ID must be an integer > 0');
        }
        
        $this->__set(self::FIELD_VOUCHER_TYPE_ID,null);
        
        return $this;
    }
    
    /**
     *  Return this voucher types name
     *
     *  @access public
     *  @return string
     *
    */
    public function getName()
    {
        return $this->__get(self::FIELD_NAME);
    }
    
    /**
     *  Set a name for this voucher type, must not be empty
     *
     *  @access public
     *  @return $this
     *  @param string $name max 100 characters
     *
    */
    public function setName($name)
    {
        if(empty($name)) {
            throw new LedgerException('Voucher type name must not be empty');
        }
        
        if(mb_strlen($name) > self::NAME_MAX_SIZE) {
            throw new LedgerException(printf('Voucher type name must be less than %s characters',self::NAME_MAX_SIZE));
        }
        
        $this->__set(self::FIELD_NAME,$name);
        
        return $this;
    }
    
    /**
     *  Sets the description of this voucher type
     *
     *  @access public
     *  @return void
     *
    */
    public function getDescription()
    {
        return $this->__get(self::FIELD_DESCRIPTION);   
    }
    
    /**
     *  Sets a description for this voucher type
     *
     *  @access public
     *  @return $this
     *  @param string $description max 500 characters
     *
    */
    public function setDescription($description)
    {
        if(mb_strlen($description) > self::DESCRIPTION_MAX_SIZE) {
            throw new LedgerException(printf('Voucher type description must be less than %s characters',self::DESCRIPTION_MAX_SIZE));
        }
     
        $this->__set(self::FIELD_DESCRIPTION,$description);
        
        return $this;
    }
    
    
    /**
     *  Get the date this voucher Type will be available from
     *
     *  @access public
     *  @return DateTime
     *
    */
    public function getEnabledFrom()
    {
        return $this->__get(self::FIELD_ENABLE_FROM);
    }
    
    /**
     *  Set date this voucher Type will be available from
     *
     *  @access public
     *  @return $this
     *  @param DateTime $from
     *
    */
    public function setEnabledFrom(DateTime $from)
    {
         $closed = $this->__get(self::FIELD_ENABLE_TO);
        
        if($closed instanceof DateTime) {
            if($closed <= $opened) {
                throw new LedgerException('Date the voucher type becomes available must occur before it has become unavailable');
            }
        }
        
        $this->__set(self::FIELD_ENABLE_FROM,$from);
        
        return $this;
    }
    
    
    /**
     *  Gets the date this voucher type will be unavailable.
     *
     *  @access public
     *  @return DateTime
     *
    */
    public function getEnabledTo()
    {
        return $this->__get(self::FIELD_ENABLE_TO);
    }
    
    /**
     *  Sets the date this voucher type will be unavailable.
     *
     *  i.e. soft delete.
     *
     *  @access public
     *  @return $this
     *  @param DateTime $to 
     *
    */    
    public function setEnabledTo(DateTime $to)
    {
        $opened = $this->__get(self::FIELD_ENABLE_FROM);
        
        if($opened instanceof DateTime) {
            if($opened >= $to) {
                throw new LedgerException('Date the voucher type becomes unavailable must occur after it has become available');
            }
        }
        
        
        $this->__set(self::FIELD_ENABLE_TO,$to);
        
        return $this;
    }
}
/* End of Class */
