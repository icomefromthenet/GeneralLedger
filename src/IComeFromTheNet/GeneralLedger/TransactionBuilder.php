<?php
namespace IComeFromTheNet\GeneralLedger;

use DateTime;

use IComeFromTheNet\GeneralLedger\Entity\LedgerTransaction;
use IComeFromTheNet\GeneralLedger\Entity\LedgerEntry;
use IComeFromTheNet\GeneralLedger\Entity\LedgerAccount;
use IComeFromTheNet\GeneralLedger\Exception\LedgerException;

class TransactionBuilder
{
    
    /**
     * @var LedgerContainer
     */ 
    protected $oContainer;
    
    /**
     * @var array(LedgerEntry)
     */ 
    protected $aLedgerEntries;
    
    /**
     * @var LedgerTransaction
     */ 
    protected $oTransactionHeader;
    
    
    /**
     * Return this lib service container
     * 
     * @access protected
     * @return LedgerContainer
     */ 
    protected function getContainer()
    {
        return $this->oContainer;
    }
    
    
    //--------------------------------------------------------------------------
    
    
    public function __construct(LedgerContainer $oContainer)
    {
        $this->oContainer = $oContainer;
    }
    
    /**
     * Return the assigned ledger entries
     * 
     * @return array(LedgerEntry)
     * @access public
     */ 
    public function getLedgerEntries()
    {
        return $this->aLedgerEntries;
    }
    
    /**
     * Constuct and return a Ledger Transaction Entity
     * 
     * @return LedgerTransaction
     * @access public
     */ 
    public function getTransactionHeader()
    {
        if(true === empty($this->oTransactionHeader)) {
            $this->oTransactionHeader = new LedgerTransaction($this->getContainer()
                                                                   ->getGatewayCollection()
                                                                   ->getGateway('ledger_transaction')
                                                            ,$this->oContainer()->getAppLogger());
        }
        
        return $this->oTransactionHeader;
    }
    
    
    
    public function setProcessingDate(DateTime $oProcessingDate)
    {
        $this->getTransactionHeader()->oProcessingDate = $oProcessingDate;
        
        return $this;
    }
    
    
    public function setOccuredDate(DateTime $oOccuredDate)
    {
        $this->getTransactionHeader()->oOccuredDate = $oOccuredDate;
        
        return $this;
    }
    
    
    public function setOrgUnit($iOrgUnitId)
    {
        $this->getTransactionHeader()->iOrgUnitID = $iOrgUnitId;
        
        return $this;
    }
    
        
    public function setVoucherNumber($sVoucherNum)
    {
        $this->getTransactionHeader()->sVoucherNumber = $sVoucherNum;
        
        return $this;
    }
    
    public function setJournalType($iJournalType)
    {
        $this->getTransactionHeader()->iJournalTypeID = $iJournalTypeID;
        
        return $this;
    }
    
    public function setUser($iUserId)
    {
        $this->getTransactionHeader()->iUserId = $iUserId;
        
        return $this;
    }
    
    
    /**
     * Add a Ledger Entry to this transaction
     * 
     * @return $this;
     * @access public
     * 
     */ 
    public function addAccountMovement($mAccountNumber,$fBalance)
    {
        
        if(!$mAccountNumber instanceof LedgerAccount) {
            $sAccountNumber = (string) $mAccountNumber;
            
            // lookup the account number
            $oAccountGateway = $this->getContainer()->getGatewayCollection()->getGateway('ledger_account');
            
            $mAccountNumber = $oAccountGateway->$gateway->selectQuery()
                 ->start()
                    ->where('account_number = :sAccountNumber')
                    ->setParamater(':sAccountNumber',$sAccountNumber)
                 ->end()
               ->findOne(); 
            
            if(true === empty($mAccountNumber)) {
                throw new LedgerException(sprintf('The account number %s does not exists in this ledger',$sAccountNumber));
            }
            
        } 
        
        
        $oMovement = new LedgerEntry($this->getContainer()
                                       ->getGatewayCollection()
                                       ->getGateway('ledger_entry')
                                     ,$this->oContainer()->getAppLogger());
        
        $oMovement->iAccountID = $mAccountNumber->iAccountID;
        $oMovement->fMovement  = $fBalance;
        
        $this->aLedgerEntries[] = $oMovement;
        
        return $this;
    }
    
    
    
}
/* End of Class */