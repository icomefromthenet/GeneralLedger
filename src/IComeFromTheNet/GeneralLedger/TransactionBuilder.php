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
    
    /**
     * Load the adjusted transactions ledger entries and will sawp the sign of the
     * account movement this allows the new transaction to reverse the original.
     * 
     * @throws LedgerException if unable to match adjusted transaction to 0 entries
     * @return array(LedgerEntry)
     * @param LedgerTransaction $oAdjustedTransaction the transaction that is being reversed
     */ 
    protected function buildReversalEntries(LedgerTransaction $oAdjustedTransaction)
    {
        
        // find account movements for this adjusted transaction
        $oEntryGateway  = $this->getContainer()->getGatewayCollection()->getGateway('ledger_entry');
        $oType          = $oEntryGateway->getMetaData()->getColumn('transaction_id')->getType();
        $iTransactionId = $oAdjustedTransaction->iTransactionID;
        
        $aEntries = $oEntryGateway->selectQuery()
             ->start()
                ->where('transaction_id = :iTransactionId')
                ->setParameter(':iTransactionId',$iTransactionId,$oType)
             ->end()
           ->find();
           
        if(0 === count($aEntries)) {
            throw new LedgerException(sprintf('A transaction at %s has no ledger entries, unable to process adjustment',$iTransactionId));
        }
        
        foreach($aEntries as $oEntry) {
            // clear the transaction id and entity id  and swap the sign.
            $oEntry->iTransactionID = null;      
            $oEntry->iEntryID       = null;
            $oEntry->fMovement      = $oEntry->fMovement  * -1;
        }
        
        return $aEntries->toArray();
        
    }

    /**
     * Execute the Transaction Processor loaded from the container.
     * 
     * @param LedgerTransaction $oAdjustedTransaction optional original transaction to reverse
     * @throws LedgerException if any errors occur during processing.
     * @return void 
     */ 
    protected function process(LedgerTransaction $oAdjustedTransaction = null) 
    {
        $oProcessor = $this->getContainer()->newTransactionProcessor();
        
        if(0 === count($this->getLedgerEntries()) && null === $oAdjustedTransaction) {
            throw new LedgerException('Unable to process transaction there are no ledger entries');
        }
       
        // make sure no account movements added if where doing a reversal as this ledger only
        // supports a full transaction reversal this is enforced by doing the entires internally.
        if($oAdjustedTransaction instanceof LedgerTransaction && 0 !== count($this->getLedgerEntries())) {
            throw new LedgerException('Not allowed to set ledger entries when process a reversal, system will do it for you');
        } elseif($oAdjustedTransaction instanceof LedgerTransaction) {
             $this->aLedgerEntries = $this->buildReversalEntries($oAdjustedTransaction);   
        }
        

        try {            
        
            // If the transaction processor does not have the DBDecorator these
            // unit of work methods will not affect any database transactions
                
            $oProcessor->start();    
                
            $oProcessor->process($this->getTransactionHeader(),$this->getLedgerEntries(),$oAdjustedTransaction); 
            
            $oProcessor->commit();
        
        }
        catch(LedgerException $e) {
            $this->getContainer()->getAppLogger()->error($e->getMessage());
            $oProcessor->rollback();
            throw $e;
        } catch(\Exception $e) {
            $this->getContainer()->getAppLogger()->error($e->getMessage());
            $oProcessor->rollback();
            throw new LedgerException($e->getMessage(),0,$e);
        }
        
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
                                                            ,$this->getContainer()->getAppLogger());
                                                            
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
    
    
    public function setOrgUnit($mOrgUnitId)
    {
        if(is_string($mOrgUnitId)) {
              
            $oGateway        = $this->getContainer()->getGatewayCollection()->getGateway('ledger_org_unit');
            $oSlugColumnType = $oGateway->getMetaData()->getColumn('org_unit_name_slug')->getType();
            
        
            $oOrgUnit = $oGateway->selectQuery()
             ->start()
                ->where('org_unit_name_slug = :sNameSlug')
                ->setParameter(':sNameSlug',$mOrgUnitId,$oSlugColumnType)
             ->end()
           ->findOne();
           
            if(true === empty($oOrgUnit)) {
                throw new LedgerException(sprintf('Unable to verify the organisation unit using name %s',$mOrgUnitId));
            }
        
            $this->getTransactionHeader()->iOrgUnitID = $oOrgUnit->iOrgUnitID;  
              
              
        } elseif(is_integer($mOrgUnitId)) {
            
            $this->getTransactionHeader()->iOrgUnitID = $mOrgUnitId;
            
        } 
        else {
             throw new LedgerException(sprintf('%s is not a valid argument',$mOrgUnitId));
        }
        
        
        return $this;
    }
    
        
    public function setVoucherNumber($sVoucherNum)
    {
        $this->getTransactionHeader()->sVoucherNumber = $sVoucherNum;
        
        return $this;
    }
    
    public function setJournalType($mJournalType)
    {
        if(is_string($mJournalType)) {
            
            $oGateway        = $this->getContainer()->getGatewayCollection()->getGateway('ledger_journal_type');
            $oSlugColumnType = $oGateway->getMetaData()->getColumn('journal_name_slug')->getType();
            
        
            $oJournalType = $oGateway->selectQuery()
             ->start()
                ->where('journal_name_slug = :sNameSlug')
                ->setParameter(':sNameSlug',$mJournalType,$oSlugColumnType)
             ->end()
           ->findOne();
           
            if(true === empty($oJournalType)) {
                throw new LedgerException(sprintf('Unable to verify the journal type using name %s',$mJournalType));
            }
        
            $this->getTransactionHeader()->iJournalTypeID = $oJournalType->iJournalTypeID;
            
            
        } elseif(is_integer($mJournalType)) {
        
            $this->getTransactionHeader()->iJournalTypeID = $mJournalType;
            
        } else {
            
            throw new LedgerException(sprintf('%s is not a valid argument',$mJournalType));
            
        }
        
        
        return $this;
    }
    
    public function setUser($mUser)
    {
        if(is_string($mUser)) {
            
            $oGateway        = $this->getContainer()->getGatewayCollection()->getGateway('ledger_user');
            $oSlugColumnType = $oGateway->getMetaData()->getColumn('external_guid')->getType();
            
        
            $oUser = $oGateway->selectQuery()
             ->start()
                ->where('external_guid = :sNameSlug')
                ->setParameter(':sNameSlug',$mUser,$oSlugColumnType)
             ->end()
           ->findOne();
           
            if(true === empty($oUser)) {
                throw new LedgerException(sprintf('Unable to verify the ledger user using name %s',$mUser));
            }
        
            $this->getTransactionHeader()->iUserID = $oUser->iUserID;
            
            
        } elseif(is_integer($mUser)) {
        
            $this->getTransactionHeader()->iUserID = $mUser;
            
        } else {
            
            throw new LedgerException(sprintf('%s is not a valid argument',$mUser));
            
        }
        
        
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
        
        $oAccountGateway = $this->getContainer()->getGatewayCollection()->getGateway('ledger_account');
        $oEntryGateway  = $this->getContainer()->getGatewayCollection()->getGateway('ledger_entry');
        $oAppLogger     = $this->getContainer()->getAppLogger();
         
        
        if(!($mAccountNumber instanceof LedgerAccount)) {
            
            // lookup the account number
            $oType           = $oAccountGateway->getMetaData()->getColumn('account_number')->getType();
            
            $oAccount = $oAccountGateway->selectQuery()
                 ->start()
                    ->where('account_number = :sAccountNumber')
                    ->setParameter(':sAccountNumber',$mAccountNumber,$oType)
                 ->end()
               ->findOne(); 
            
            if(true === empty($oAccount)) {
                throw new LedgerException(sprintf('The account at %s id does not exists in this ledger',$mAccountNumber));
            }
            
        } 
        
        
        $oMovement = new LedgerEntry($oEntryGateway,$oAppLogger);
        
        $oMovement->iAccountID = $oAccount->iAccountID;
        $oMovement->fMovement  = $fBalance;
        
        $this->aLedgerEntries[] = $oMovement;
        
        return $this;
    }
    
    
    /**
     * Save the built transaction to the database using the default
     * transaction processor fetched from the DI Container
     * 
     * @return void
     * @throws LedgerException if the transaction fails to save.
     */ 
    public function processTransaction() 
    {
        return $this->process(null);        
   
    }
    
    /**
     * Save the built transaction to the database using the default
     * transaction processor fetched from the DI Container, Also update
     * the adjusteed transaction with the new transactions database id
     * 
     * @return void
     * @throws LedgerException if the transaction fails to save.
     * @param LedgerTransaction $oAdjustedTransaction The transaction that is being adjusted.
     */
    public function processAdjustment(LedgerTransaction $oAdjustedTransaction)
    {
        return $this->process($oAdjustedTransaction);
    }
    
}
/* End of Class */