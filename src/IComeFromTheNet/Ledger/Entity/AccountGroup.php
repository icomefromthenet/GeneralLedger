<?php
namespace IComeFromTheNet\Ledger\Entity;

use DateTime;
use IComeFromTheNet\Ledger\Exception\LedgerException;

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
class AccountGroup
{
    CONST GROUP_NAME_MAX_SIZE = 50;
    
    CONST GROUP_DESC_MAX_SIZE = 150;
    
    protected $groupID;
    
    protected $groupName;
    
    protected $groupDescription;
    
    protected $dateAdded;
    
    protected $dateRemoved;
    
    /*
     * @var integer the parent group using Adjacency List Model
     */
    protected $parentGroupID;

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
        
        $this->groupID = $id;
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
        return $this->groupID;
    }
    
     /**
     *  Fetches parent group ID
     *
     *  @access public
     *  @return integer | null the parent group id
     *
    */
    public function getParentGroupID()
    {
        return $this->parentGroupID;
    }
    
    /**
     *  Sets parent group ID
     *
     *  @access public
     *  @return void
     *
    */
    public function setParentGroupID($parentGroupId)
    {
        $this->parentGroupID = $parentGroupID;
    }
    
    /**
     *  Sets the group name
     *
     *  @access public
     *  @return void
     *  @param string $name the group name
     *
    */
    public function setName($name)
    {
        if(empty($name) || mb_strlen((string)$name) > self::GROUP_NAME_MAX_SIZE ) {
            throw new LedgerException(
                            sprintf('Group Name must be a string < %s characters',self::GROUP_NAME_MAX_SIZE)
                        );
        }
        
        
        $this->groupName = $name;
    }
    
    /**
     *  Fetch the account group name
     *
     *  @access public
     *  @return string the group name
     *
    */
    public function getName()
    {
        return $this->groupName;
    }
    
    /**
     *  Set the group description
     *
     *  @access public
     *  @return void
     *  @param string a short group description
     *
    */
    public function setDescription($description)
    {
        if(empty($description) || mb_strlen((string)$description) > self::GROUP_DESC_MAX_SIZE ) {
            throw new LedgerException(
                            sprintf('Group Description must be a string < %s characters',self::GROUP_DESC_MAX_SIZE)
                        );
        }
        
        
        $this->groupDescription = $description;
    }
    
    /**
     *  Fetch the group description 
     *
     *  @access public
     *  @return string the group description
     *
    */
    public function getDescription()
    {
        return $this->groupDescription;
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
        return $this->dateAdded;
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
        return $this->dateRemoved;
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
        $this->dateAdded = $added;
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
        $this->dateRemoved = $removed;
    }
    
   
    
}
/* End of Class */