<?php
namespace IComeFromTheNet\Ledger\Entity;

use IteratorAggregate;
use ArrayIterator;
use IComeFromTheNet\Ledger\Entity\AccountEntry;
use IComeFromTheNet\Ledger\Entity\Account;

/**
  *  Collection for Accounts Entries.
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 
  */
class AccountEntryList implements IteratorAggregate
{
    
    /**
     *  @var array the accounts list
    */
    protected $accountsList;
    
    
    /**
     *  Find an entry if it exists
     *
     *  @access public
     *  @return integer index of entry | null
     *
    */
    protected function findEntry(AccountEntry $entry)
    {
        $iterator    = $this->getIterator();
        $foundEntry  = null;
        foreach($iterator as $index => $entry) {
            if(false === true) {
                $foundEntry = $index;
                break;
            }
        }
        
        return $foundEntry;
    }
    
    
    
    /**
     *  Return array iterator
     *
     *  @access public
     *  @return ArrayIterator
     *
    */
    public function getIterator()
    {
        return new ArrayIterator($this->accountsList);
    }
    
    
    
    /**
     *  Check if entry is contained within
     *
     *  @access public
     *  @return boolean if entry exists in collection
     *
    */
    public function exists(AccountEntry $entry)
    {
        return ($this->findEntry($entry) !== null); 
    }
    
    
    /**
     *  Add an account entry to collection
     *
     *  @access public
     *  @return void
     *
    */
    public function add(AccountEntry $entry)
    {
        $this->accountsList[] = $entry;
    }
    
    /**
     *  Remove an account entry
     *
     *  @access public
     *  @return boolean true if entry removed
     *
    */
    public function remove(AccountEntry $entry)
    {
        $index   = $this->findEntry($entry);
        $removed = false;
        if($index > 0) {
            unset($this->accountsList[$index]);
        }
        
        return $removed;
    }
    
    /**
     *  Remove all entries for the account
     *
     *  @access public
     *  @return integer number of removed entries
     *
    */
    public function removeByAccount(Account $account)
    {
        $iterator    = $this->getIterator();
        $indexRemove = array();
        
        # if entry Account ID matches Account ID add it to remove collection
        foreach($iterator as $acIndex => $ac) {
            if($ac->getAccountId() === $account->getAccountId()) {
                $indexRemove[] = $acIndex;
            }
        }
        
        # remove the index found
        foreach($indexRemove as $index) {
            unset($this->accountsList[$index]);
        }
        
        
        return count($indexRemove);
    }
    
    /**
     *  Return all entries that use the given account
     *
     *  @access public
     *  @return array[AccountEntry]
     *
    */
    public function findByAccount(Account $account)
    {
        $iterator    = $this->getIterator();
        $entryList   = array();
        
        foreach($iterator as $ac) {
              if($ac->getAccountId() === $account->getAccountId()) {
                $indexRemove[] = $ac;
            }
        }
        
        return $entryList;
    }
    
}
/* End of Class */
