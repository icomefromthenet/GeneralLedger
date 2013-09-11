<?php
namespace IComeFromTheNet\Ledger\Entity;

use DateTime;
use IComeFromTheNet\Ledger\Exception\LedgerException;

/**
  *  Represent A single account
  *
  *  Each account can have one group 
  *
  *  Once an account it closed it cannot be opened again
  *  A max date on closing is used to represent open account
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class Account
{
    
    const MAX_ACCOUNT_NAME_SIZE = 150;
    
    
    protected $accountNumber;
    
    protected $accountName;
    
    protected $dateOpened;
    
    protected $dateClosed;
    
    protected $accountGroup;
    
    /**
     *  Fetch the account number
     *
     *  @access public
     *  @return integer the account number
     *
    */
    public function getAccountNumber()
    {
        return $this->accountNumber;
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
        
        $this->accountNumber = $number;
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
        return $this->accountName;
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
        
        $this->accountName = $name;
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
        return $this->dateOpened;
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
        if($this->dateClosed instanceof DateTime) {
            if($this->dateClosed <= $opened) {
                throw new LedgerException('Date the account opened must be before the set closed date');
            }
        }
        
        $this->dateOpened = $opened;
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
        return $this->dateClosed;
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
        if($this->dateOpened instanceof DateTime) {
            if($this->dateOpened >= $closed) {
                throw new LedgerException('Date the account closed must be after the set opening date');
            }
        }
        
        $this->dateClosed = $closed;
    }
    
    /**
     *  Sets the group ID
     *
     *  @access public
     *  @return integer | null
     *
    */
    public function getGroupId()
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
    public function setGroupId($id)
    {
        if($id <= 0) {
            throw new LedgerException('The account Group ID must be > 0');
        }
        
        $this->accountGroup = $id;
    }
    
}
/* End of Class */
