<?php
namespace IComeFromTheNet\GeneralLedger\TrialBalance;

use IComeFromTheNet\GeneralLedger\Exception\LedgerException;
use BlueM\Tree;

/**
 * Tree for a Ledger Accounts.
 * 
 * Each account will have 1 parent and n children.
 * The balance of that account is the balance of children + balance of the current account.
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
 class AccountTree extends Tree
 {
     
    /**
     * Creates and returns a node with the given properties
     *
     * @param array $properties
     *
     * @return Node
     */
    protected function createNode(array $aProperties)
    {
        return new AccountNode(
             $aProperties['account_id']
           , $aProperties['parent_account_id']
           , $aProperties['account_number']
           , $aProperties['account_name']
           , $aProperties['account_name_slug']
           , $aProperties['hide_ui']
           , $aProperties['is_debit']
           , $aProperties['is_credit']
        );
    }
    
    /**
     * Have nodes in this tree calculate their combined balances.
     * 
     * ie own + children.
     * 
     * @access public
     * @return AccountTree
     */ 
    public function calculateCombinedBalances()
    {
        foreach($this->getRootNodes() as $aNode)
        {
            $aNode->calculateCombinedBalances();
        }
        
        $this->freezeTree();
        
        return $this;
    }
    
    /**
     * Freeze the nodes of this tree from accepting balance changes
     *  
     * @return AccountTree
     * @access public
     */ 
    public function freezeTree()
    {
        
        foreach($this->getRootNodes() as $aNode)
        {
            $fBalance += $aNode->freeze();
        }
        
        return $this;
    }
    
     
 }
 /* End of file */