<?php
namespace IComeFromTheNet\GeneralLedger\TrialBalance;

use Doctrine\Common\Collections\ArrayCollection;
use IComeFromTheNet\GeneralLedger\Exception\LedgerException;

/**
 * Tree Node for a Ledger Account.
 * 
 * 
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
 class AccountNode 
 {
     
    protected $iDatabaseID;
    
    protected $sAccountNumber;
    
    protected $sAccountName;
     
    protected $sAccountNameSlug;
    
    protected $aChildren;
    
    protected $oParentAccount;
    
    protected $fBalance;
    
    protected $bFrozen;
    
    
    
    
    public function __construct($iDatabaseID,$sAccountNumber,$sAccountName,$sAccountNameSlug)
    {
        $this->iDatabaseID      = $iDatabaseID;
        $this->sAccountName     = $sAccountName;
        $this->sAccountNameSlug = $sAccountNameSlug;
        $this->sAccountNumber   = $sAccountNumber;
        $this->bFrozen          = false;
        $this->aChildren        = array();
        $this->oParentAccount   = null;
        $this->fBalance         = 0;
    }
    
    
    
    public function getDatabaseID()
    {
        return $this->iDatabaseID;
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
    
    
    //-------------------------------------------------------------------------
    # tree methods
    
    public function freeze()
    {
        $this->bFrozen = true;
    }
    
    public function isFrozen()
    {
        return $this->bFrozen;
    }
    
    public function getChildren()
    {
        
    }
    
    public function getParent()
    {
        
    }
    
    public function setParent()
    {
        
    }
    
     
 }
 /* End of file */