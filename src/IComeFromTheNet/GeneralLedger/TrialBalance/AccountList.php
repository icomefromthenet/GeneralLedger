<?php
namespace IComeFromTheNet\GeneralLedger\TrialBalance;

use Doctrine\Common\Collections\ArrayCollection;
use IComeFromTheNet\GeneralLedger\Exception\LedgerException;

/**
 * A flat list of account nodes index by the database account id.
 * 
 * The first node is always the root of the account tree.
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class AccountList extends ArrayCollection
{
    
    /**
     * Initializes a new ArrayCollection.
     *
     * @param array $elements
     */
    public function __construct(array $aElements = array())
    {
        parent::__construct($aElements);
        
        if(false === isset($aElements[0])) {
            throw new LedgerException('A root account node must be included in list constructor');
        }
        
    }
    
    /**
     * Fetch the root node. 
     * 
     * @access public
     * @return AccountNode
     */ 
    public function getRootNode()
    {
        // index is the database account id.
        // this collection is 0 based but database is not.
        
        return $this->get(1);
    }
    
}
/* End of file */