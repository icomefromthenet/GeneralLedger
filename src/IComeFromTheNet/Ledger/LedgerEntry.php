<?php
namespace IComeFromTheNet\Ledger;

use Doctrine\DBAL\Connection;
use IComeFromTheNet\Ledger\AccountList;
use IComeFromTheNet\Ledger\Exception\LedgerException;
use IComeFromTheNet\Ledger\Entity\LedgerTransaction;

/**
  *  A Unit of work for createing a general edger transaction
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 
  */
class LedgerEntry extends UnitOfWork
{
    
    /**
     * @var Doctrine\DBAL\Connection
    */
    protected $dbal;
    
    /**
     * @var IComeFromTheNet\Ledger\AccountList
    */
    protected $accountList;
    
    /**
     * @var IComeFromTheNet\Ledger\Entity\LedgerTransaction
    */
    protected $ledgerTransaction;
        
    /**
     *
     *
     */
    public function __construct(Connection $connection,
                                AccountList $list,
                                LedgerTransaction $transaction)
    {
        $this->dbal              = $connection;
        $this->accountList       = $list;
        $this->ledgerTransaction = $transaction;
    }
    
    
    /**
     *  Return the accounts list for this entry
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\AccountList
     *
    */
    public function getAccountEntryList()
    {
        return $this->accountList;
    }
    
    
    /**
     *  Return the database connection  
     *
     *  @access public
     *  @return  Doctrine\DBAL\Connection
     *
    */
    public function getDBAL()
    {
        return $this->dbal;
    }
    
     
    /**
     *  Return the database connection  
     *
     *  @access public
     *  @return  IComeFromTheNet\Ledger\Entity\LedgerTransaction
     *
    */
    public function getLedgerTransaction()
    {
        return $this->ledgerTransaction;
    }
    
    //---------------------------------------------------------------------
    # API Methods to control Database Transaction

    
    /**
     *  Start this unit of work
     *
     *  @access protected
     *  @return void
     *
    */
    protected function start()
    {
        $this->dbal->start();
    }
    
    
    /**
     *  Commit the result of the Unit of work
     *
     *  @access protected
     *  @return void
     *
    */
    protected function commit()
    {
        $this->dbal->commit();
    }
    
     /**
     *  Cause a rollback of this Unit of Work
     *
     *  @access public
     *  @return void
     *
    */
    protected function rollback()
    {
        $this->dbal->rollback();
    }
    
     /**
     *  Process the unit of work
     *
     *  @access public
     *  @return void
     *
    */
    public function process()
    {
        
        try {
            
            # generate new Ledger Transaction
            
            
            
        } catch (LedgerException $e) {
            
            
                
        }
        
        
        
    }
}
/* End of Class */
