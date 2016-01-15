<?php
namespace IComeFromTheNet\GeneralLedger\TrialBalance;

use Doctrine\Common\Collections\ArrayCollection;
use IComeFromTheNet\GeneralLedger\Exception\LedgerException;
use BlueM\Tree\Node;

/**
 * Tree Node for a Ledger Account.
 * 
 * To calculate the full account balance
 * 
 * 1. Must set the basic balance using self::setBasicBalance()
 * 2. Must call self::calculateCombinedBalances() 
 * 3. Must call self::Freeze() to stop modifications
 * 4. To fetch the balance call self::getBalance()
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
 class AccountNode extends Node
 {
     
    
    
    public function __construct($iDatabaseID, $iParentID, $sAccountNumber, $sAccountName, $sAccountNameSlug, $bHideUi, $bIsDebit, $bIsCredit)
    {
        
        parent::__construct(array(
            'id'                => $iDatabaseID
            ,'parent'           => $iParentID 
            
            ,'sAccountName'     => $sAccountName
            ,'sAccountNameSlug' => $sAccountNameSlug
            ,'sAccountNumber'   => $sAccountNumber
            ,'bHideUI'          => $bHideUi
            ,'bFrozen'          => false 
            ,'fBalance'         => 0.00
            ,'bIsDebit'         => $bIsDebit
            ,'bIsCredit'        => $bIsCredit

        ));
      
    }
    
    
    
    public function getDatabaseID()
    {
        return $this->id;
    }
    
    public function getAccountNumber()
    {
        return $this->sAccountNumber;
    }
    
    public function getAccountName()
    {
        return $this->sAccountName;
    }
    
    public function getAccountNameSlug()
    {
        return $this->sAccountNameSlug;
    }
    
    public function isDebit() 
    {
        return $this->bIsDebit && false == $this->bIsCredit;    
    }
    
    public function isCredit() 
    {
        return $this->bIsCredit && false == $this->bIsDebit;    
    }
    
    //-------------------------------------------------------------------------
    # Freeze methods
    
    public function freeze()
    {
        $this->bFrozen = true;
    }
    
    public function isFrozen()
    {
        return $this->bFrozen;
    }
    
   //--------------------------------------------------------------------------
   # Balance

  /**
   * Set the basic balance of this account which is the sum of all transaction but not
   * including those of any children
   * 
   * @access public
   * @return AccountNode
   */ 
  public function setBasicBalance($fBalance)
  {
      if(true === $this->isFrozen()) {
          throw new LedgerException('This Account Tree Node is fronzen to modifications');
      }
      
      $this->fBalance = $fBalance;
        
      return $this;    
            
  }
  
  /**
   * Calculate the actual balance of the account.
   * 
   * The actual balance is the Basic Balance + Balance of all children
   * 
   * @access public
   * @retun float the caluclated balance
   */ 
  public function calculateCombinedBalances()
  {
      if(true === $this->isFrozen()) {
          throw new LedgerException('This Account Tree Node is fronzen to modifications');
      }
       
      $fBalance = 0.00;
      
      foreach($this->getChildren() as $aNode) {
          $fBalance += $aNode->calculateCombinedBalances();
          $aNode->freeze();    
      }
      
      $this->fBalance = $this->fBalance + $fBalance;
      
      $this->freeze();
      
      return $this->fBalance;
  }
  
  /**
   * Return the account actual balance after the account node
   * has been fronzen to modification
   * 
   * @return float the account balance
   * @access public
   */ 
  public function getBalance()
  {
      if(false === $this->isFrozen()) {
          throw new LedgerException('Unable to return Account Node balance as this node is not fronzen and could be modified');
      }
      
      return $this->fBalance;
  }
    
     
 }
 /* End of file */