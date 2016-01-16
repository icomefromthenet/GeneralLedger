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
        if($aProperties['id'] !== 1) {
        
            $oNode = new AccountNode(
                 $aProperties['id']
               , $aProperties['parent']
               , $aProperties['account_number']
               , $aProperties['account_name']
               , $aProperties['account_name_slug']
               , $aProperties['hide_ui']
               , $aProperties['is_debit']
               , $aProperties['is_credit']
            );
            
            if(true === array_key_exists('balance',$aProperties)) {
                $oNode->setBasicBalance($aProperties['balance']);
            }
            
            return $oNode;
        
        } else {
            return parent::createNode($aProperties);
        }
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