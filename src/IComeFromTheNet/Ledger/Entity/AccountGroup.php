<?php
namespace IComeFromTheNet\Ledger\Entity;

use DateTime;
use IComeFromTheNet\Ledger\Exception\LedgerException;
use Aura\Marshal\Entity\GenericEntity;

/**
  *  Container for a group of accounts
  *
  *  Group may be grouped together using Adjacency List Model
  *  A group can be soft_deleted by setting its removed date.
  *  Lack of removal is need to keep trial balance consistent.
  *
  *  The name and the description may be updated at anytime. 
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class AccountGroup extends GenericEntity
{
    CONST GROUP_NAME_MAX_SIZE = 150;
    CONST GROUP_DESC_MAX_SIZE = 500;
    
    const FIELD_GROUP_ID           = 'account_group_id';
    const FIELD_GROUP_NAME         = 'group_name';
    const FIELD_GROUP_DESCRIPTION  = 'group_description';
    const FIELD_DATE_ADDED         = 'group_date_added';
    const FIELD_DATE_REMOVED       = 'group_date_removed'; 

    
    
    public function __construct(array $data = array())
    {
        parent::__construct($data);
        
        $this->__set(self::FIELD_GROUP_ID,null);
        $this->__set(self::FIELD_GROUP_NAME,null);
        $this->__set(self::FIELD_GROUP_DESCRIPTION,null);
        $this->__set(self::FIELD_DATE_ADDED,null);
        $this->__set(self::FIELD_DATE_REMOVED,null);
    }
    
    
    
    
    /**
     *  Sets the group ID
     *
     *  @access public
     *  @return void
     *  @param integer the group storage id
     *
    */
    public function setGroupID($id)
    {
        if(is_int($id) === false || (integer) $id < 0) {
            throw new LedgerException(sprintf('AccountGroupID must be an integer > 0'));
        }
        
        $this->__set(self::FIELD_GROUP_ID,$id);
    }

    /**
     *  fetch the group ID
     *
     *  @access public
     *  @return integer the group id
     *
    */    
    public function getGroupID()
    {
        return $this->__get(self::FIELD_GROUP_ID);
    }
    
    /**
     *  Sets the group name
     *
     *  @access public
     *  @return void
     *  @param string $name the group name
     *
    */
    public function setGroupName($name)
    {
        if(empty($name) || mb_strlen((string)$name) > self::GROUP_NAME_MAX_SIZE ) {
            throw new LedgerException(
                            sprintf('Group Name must be a string < %s characters',self::GROUP_NAME_MAX_SIZE)
                        );
        }
        
        
        $this->__set(self::FIELD_GROUP_NAME,$name);
    }
    
    /**
     *  Fetch the account group name
     *
     *  @access public
     *  @return string the group name
     *
    */
    public function getGroupName()
    {
        return $this->__get(self::FIELD_GROUP_NAME);
    }
    
    /**
     *  Set the group description
     *
     *  @access public
     *  @return void
     *  @param string a short group description
     *
    */
    public function setGroupDescription($description)
    {
        if(empty($description) || mb_strlen((string)$description) > self::GROUP_DESC_MAX_SIZE ) {
            throw new LedgerException(
                            sprintf('Group Description must be a string < %s characters',self::GROUP_DESC_MAX_SIZE)
                        );
        }
        
        
        $this->__set(self::FIELD_GROUP_DESCRIPTION, $description);
    }
    
    /**
     *  Fetch the group description 
     *
     *  @access public
     *  @return string the group description
     *
    */
    public function getGroupDescription()
    {
        return $this->__get(self::FIELD_GROUP_DESCRIPTION);
    }
    
    /**
     *  Fetch the date the group was opened
     *
     *  @access public
     *  @return DateTime
     *
    */
    public function getDateAdded()
    {
        return $this->__get(self::FIELD_DATE_ADDED);
    }
    
    /**
     *  Fetch the date the group was closed
     *
     *  @access public
     *  @return DateTime
     *
    */
    public function getDateRemoved()
    {
        return $this->__get(self::FIELD_DATE_REMOVED);
    }
    
    /**
     *  Sets the date the group setup
     *
     *  @access public
     *  @return void
     *
    */
    public function setDateAdded(DateTime $added)
    {
        $removed = $this->__get(self::FIELD_DATE_REMOVED);
        
        if($removed instanceof DateTime) {
            if($removed <= $added) {
                throw new LedgerException('Date the group added must be before the set removal date');
            }
        }
        
        $this->__set(self::FIELD_DATE_ADDED,$added);
    }
    
    /**
     *  Sets the date Group was closed
     *
     *  @access public
     *  @return void
     *
    */
    public function setDateRemoved(DateTime $removed)
    {
        $added = $this->__get(self::FIELD_DATE_ADDED);
        
        if($added instanceof DateTime) {
            if($added >= $removed) {
                throw new LedgerException('Date the group removed must be after the set added date');
            }
        }
        
        $this->__set(self::FIELD_DATE_REMOVED ,$removed);
    }
    
    
    
    /**
     *  Gets the parent group
     *
     *  @access public
     *  @return AccountGroup
     *
    */
    public function getParentAccountGroup()
    {
        return $this->parentGroup;
    }
    
    
    /**
     *  Sets the Parent Group of this Group
     *
     *  @access public
     *  @return void
     *  @param AccountGroup $parentGroup the parent group
     *
    */
    public function setParentAccountGroup(AccountGroup $parentGroup)
    {
        $this->parentGroup = $parentGroup;
    }
    
}
/* End of Class */