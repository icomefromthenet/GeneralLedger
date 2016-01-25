<?php
namespace IComeFromTheNet\GeneralLedger;

use IComeFromTheNet\GeneralLedger\Entity\LedgerTransaction;
use IComeFromTheNet\GeneralLedger\Entity\LedgerEntry;

/**
 * This interface provides class with the ability to process Ledger Transactions. 
 * 
 * If a transaction is adjusted the existing transaction must be reversed and a new transaction must be 
 * created at the same occured date but with current processing date. To make the adjustment requires 2
 * transactions the first to reverse and second to replace. 
 * 
 * The replacment is not linked to the original by any Foregin keys. Only link the original to the reverse adjustment.
 * As the replacement transaction have the same occured date if they are listed they will be grouped together.
 * 
 * Also need a seperate replacement transaction to allow a different  orgUnit/User/Voucher to be applied.
 * The Reversal transaction should have a different voucher number. 
 * 
 * Look at a example of a purchase that been adjusted we should see the following.
 * 
 * 1. Original sales transaction with a sales recepit voucher.
 * 2. A reversal transaction with a credit note voucher.
 * 3. A replacment transaction with a new sales recepit voucher.
 * 
 * Can we do a partial reversal? Yes you may the implementors will reverse the entire transaction unless you
 * provide own entries. 
 * 
 * Implementors should also implement the UnitOfWork Interface to allow control of a database transaction.  
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
interface TransactionProcessInterface
{
    
    /**
     * Return the app logger
     * 
     * @access public
     * @return use Psr\Log\LoggerInterface;
     */ 
    public function getLogger();
    
    /**
     *  Return the database connection  
     *
     *  @access public
     *  @return  Doctrine\DBAL\Connection
     *
    */
    public function getDatabaseAdapter();
    
    /**
     * Process a new transaction 
     * 
     * The param $oReversedLedgerTrans is only required if creating a reversal.
     * 
     * @param   LedgerTransaction   $oLedgerTrans           The new transaction to make 
     * @param   array               $aLedgerEntries         Array of Ledger Entries (account movements) to save
     * @param   LedgerTransaction   $oAdjustedLedgerTrans   The transaction that is to be reversed by this new transaction
     */ 
    public function process(LedgerTransaction $oLedgerTrans, array $aLedgerEntries, LedgerTransaction $oAdjustedLedgerTrans = null);

}
/* End of Class */