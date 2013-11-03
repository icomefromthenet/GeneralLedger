<?php
namespace IComeFromTheNet\Ledger\Entity;

use DateTime;
use IComeFromTheNet\Ledger\Exception\LedgerException;
use IComeFromTheNet\Ledger\Entity\AccountGroup;
use Aura\Marshal\Entity\GenericEntity;


/**
  *  Represents a single account
  *
  *  Each account can have one group 
  *
  *  Once an account it closed it cannot be opened again
  *  A max date on closing is used to represent open account
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class Account extends GenericEntity
{
    
    const MAX_ACCOUNT_NAME_SIZE = 150;
    
    
    const FIELDS_ACCOUNT_NUMBER = 'accountNumber';
    const FIELDS_ACCOUNT_NAME   = 'accountName';
    const FIELDS_DATE_OPENED    = 'dateOpened';
    const FIELDS_DATE_CLOSED    = 'dateClosed';
    
    
    
    
    public function __construct(array $data = array())
    {
        parent::__construct($data);
        
        $this->__set(self::FIELDS_ACCOUNT_NUMBER,null);
        $this->__set(self::FIELDS_ACCOUNT_NAME,null);
        $this->__set(self::FIELDS_DATE_CLOSED,null);
        $this->__set(self::FIELDS_DATE_OPENED,null);
        
    }
    
    
    /**
     *  Fetch the account number
     *
     *  @access public
     *  @return integer the account number
     *
    */
    public function getAccountNumber()
    {
        return $this->__get(self::FIELDS_ACCOUNT_NUMBER);
    }
    
    /**
     *  Sets the account number
     *
     *  @access public
     *  @return void
     *  @param integer $number
     *
    */
    public function setAccountNumber($number)
    {
        if(!is_integer($number) || (integer) $number <= 0) {
            throw new LedgerException('Account number must be an integer > 0');
        }
        
        $this->__set(self::FIELDS_ACCOUNT_NUMBER, $number);
    }
    
    /**
     *  Get the account name
     *
     *  @access public
     *  @return string
     *
    */
    public function getAccountName()
    {
        return $this->__get(self::FIELDS_ACCOUNT_NAME);
    }
    
    /**
     *  Sets the account name
     *
     *  @access public
     *  @return void
     *
    */
    public function setAccountName($name)
    {
        
        if(empty($name) || mb_strlen((string)$name) > self::MAX_ACCOUNT_NAME_SIZE) {
            throw new LedgerException(
                                sprintf('Account Name must be a string < %s characters',self::MAX_ACCOUNT_NAME_SIZE)
                            );
        }
        
        $this->__set(self::FIELDS_ACCOUNT_NAME,$name);
    }
    
    /**
     *  Feth the date the account opened
     *
     *  @access public
     *  @return DateTime
     *
    */
    public function getDateOpened()
    {
        return $this->__get(self::FIELDS_DATE_OPENED);
    }
    
    /**
     *  Sets the date the account opened
     *
     *  @access public
     *  @return void
     *
    */
    public function setDateOpened(DateTime $opened)
    {
        $closed = $this->__get(self::FIELDS_DATE_CLOSED);
        
        if($closed instanceof DateTime) {
            if($closed <= $opened) {
                throw new LedgerException('Date the account opened must be before the set closed date');
            }
        }
        
        $this->__set(self::FIELDS_DATE_OPENED,$opened);
    }
    
    /**
     *  Get the Date the Account was closed
     *
     *  @access public
     *  @return DateTime
     *
    */
    public function getDateClosed()
    {
        return $this->__get(self::FIELDS_DATE_CLOSED);
    }
    
    /**
     *  Sets the date the account closed
     *
     *  @access public
     *  @return void
     *
    */
    public function setDateClosed(DateTime $closed)
    {
        $opened = $this->__get(self::FIELDS_DATE_OPENED);
        
        if($opened instanceof DateTime) {
            if($opened >= $closed) {
                throw new LedgerException('Date the account closed must be after the set opening date');
            }
        }
        
        $this->__set(self::FIELDS_DATE_CLOSED,$closed);
    }
    
    /**
     *  Sets the group ID
     *
     *  @access public
     *  @return integer | null
     *
    */
    public function getAccountGroup()
    {
        return $this->accountGroup;
    }
    
    /**
     *  Sets the group ID
     *
     *  @access public
     *  @return void
     *  @param integer $id the group id
     *
    */
    public function setAccountGroup(AccountGroup $accountGroup)
    {
        $this->accountGroup = $accountGroup;
    }
    
}
/* End of Class */
