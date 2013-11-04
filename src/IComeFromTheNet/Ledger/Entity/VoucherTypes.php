<?php
namespace IComeFromTheNet\Ledger\Entity;

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
class VoucherTypes
{
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
    
    
    
    public function getVoucherTypeID()
    {
        return $this->__get(self::FIELD_VOUCHER_TYPE_ID);
    }
    
    
    public function setVoucherTypeID($id)
    {
        if(!is_init($id) || (int) $id <= 0) {
            throw new LedgerException('VoucherTypeID must be an integer > 0');
        }
        
        $this->__set(self::FIELD_VOUCHER_TYPE_ID,null);
        
        return $this;
    }
    
}
/* End of Class */
