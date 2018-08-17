<?php
namespace IComeFromTheNet\GeneralLedger\TrialBalance;

use IComeFromTheNet\GeneralLedger\Exception\LedgerException;
use BlueM\Tree;
use BlueM\Tree\Node;

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
    protected function createNode($id, $parent, array $properties): Node
    {
        // test for root node
        if($this->rootId === $id) {
            return parent::createNode($id, $parent, $properties);
        }
        
        $oNode = new AccountNode(
             $id
           , $parent
           , $properties['account_number']
           , $properties['account_name']
           , $properties['account_name_slug']
           , $properties['hide_ui']
           , $properties['is_debit']
           , $properties['is_credit']
        );
        
        if(true === array_key_exists('balance',$properties)) {
            $oNode->setBasicBalance($properties['balance']);
        }
        
        return $oNode;
        
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
        
        return $this;
    }

    
     
 }
 /* End of file */