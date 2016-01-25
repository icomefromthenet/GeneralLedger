GeneralLedger
=============

General Ledger for PHP and MySql.

A [general ledger](https://www.google.com.au/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8&client=ubuntu#q=define%3Ageneral%20ledger) is a complete record of financial transactions over the life of a company. The ledger holds account information that is needed to prepare financial statements, and includes accounts for assets, liabilities, owners' equity, revenues and expenses.


Installing
---------------

Step 1. You can install this library using composer. 

```json
    icomefromthenet/ledger : 1.0 
```

Step 2. Create a new database called 'general_ledger' and run the database build script under database/database.sql

```bash
    mysql general_ledger < database/database.sql
```

> I use my own database migration tool called [Migrations](https://github.com/icomefromthenet/Migrations) but I have included a sql file for convenience.


Terms and conventions
----------------------

### 1. Debits / Credit.
A debit is a value with a positive sign, a credit is a value with a negative sign. 

### 2. Transaction
For purposes of this library a transaction is represented by a single entry into the general ledger with each transaction having 1 to many account movements. 

### 3. Organisation Unit (Cost Center)
Organisation Units are used to group transactions with each having a relation to ONE and therefore should be mutually exclusive. For example departments in an organisation.

### 4. Ledger User.
Each transaction is subscribed to a single user this most likely your application users.

### 5. Ledger Entry / Account movement.
Each entry represents an allocation to a ledger account. 

### 6. Ledger Account
Each account can hold one to many child accounts think of it like a tree.

### 6. Trail Balance
Aggerates all enteries which are then split into debits and credits. The ledger is said to be in balance if debits equals credit. 

### 7. Adjustments
To make a correction a transaction must be adjusted through a reversal and a re-issue we do NOT delete transactions in our ledgers. 


Create a Transaction
---------------------

1. Instance the library DI container.
2. Instance the transaction builder.
3. Fetch the current date from the database. 
4. Set transaction details and run.

```php
use Doctrine\DBAL\Connection;
use Monolog\Logger;
use Monolog\Handler\TestHandler;
use Symfony\Component\EventDispatcher\EventDispatcher;
use IComeFromTheNet\GeneralLedger\LedgerContainer;
use IComeFromTheNet\GeneralLedger\TransactionBuilder;


# instance the Library DI Container.

$oAppLog   = new new Logger('test-ledger',array(new TestHandler()));
$oDatabase = new Connection(array());
$oEvent    = new EventDispatcher();

$oLedgerContainer = new LedgerContainer($oEvent, $oDatabase, $oAppLog);
$oLedgerContainer->boot();

# fetch processing date from the database 

$oProcessingDate = $oLedgerContainer->getNow(); 

# instance the Transaction Builder and configure our builder with transaction.

$oTBuilder = new TransactionBuilder($oLedgerContainer);

$oTBuilder->setProcessingDate($oProcessingDate); 
$oTBuilder->setOccuredDate(new DateTime('now - 6 day'));
$oTBuilder->setOrgUnit('homeoffice');
$oTBuilder->setVoucherNumber('10004');
$oTBuilder->setJournalType('sales_journal');
$oTBuilder->setUser('586DB7DF-57C3-F7D5-639D-0A9779AF79BD');


# Add Some account movements

$oTBuilder->addAccountMovement('2-1120',100);
$oTBuilder->addAccountMovement('2-1121',-100);

# process the transaction, if no exceptions then we have a sucessful transaction

$oTBuilder->processTransaction();
       
$oTransaction = $oTBuilder->getTransactionHeader();

echo 'Transaction ID'  . $oTransaction->iTransactionID;


```

>  You really should not assume your webserver and database server running same date settings. 


Create a Adjustment
---------------------

1. Instance the library DI container.
2. Instance the transaction builder.
3. Fetch the current date from the database. 
4. Fetch the transaction that were looking to reverse.
5. Process an adjustment and then do the replacement.


```php
use Doctrine\DBAL\Connection;
use Monolog\Logger;
use Monolog\Handler\TestHandler;
use Symfony\Component\EventDispatcher\EventDispatcher;
use IComeFromTheNet\GeneralLedger\LedgerContainer;
use IComeFromTheNet\GeneralLedger\TransactionBuilder;

$oAppLog   = new new Logger('test-ledger',array(new TestHandler()));
$oDatabase = new Connection(array());
$oEvent    = new EventDispatcher();

$oLedgerContainer = new LedgerContainer($oEvent, $oDatabase, $oAppLog);
$oLedgerContainer->boot();

# fetch processing date from the database 

$oProcessingDate = $oLedgerContainer->getNow(); 

# instance the Transaction Builder and configure our builder with transaction.

$oTBuilder = new TransactionBuilder($oLedgerContainer);

        
$oTBuilder->setProcessingDate($oProcessingDate); 
$oTBuilder->setOccuredDate(new DateTime('now - 6 day'));
$oTBuilder->setOrgUnit('homeoffice');
$oTBuilder->setVoucherNumber('10004');
$oTBuilder->setJournalType('sales_journal');
$oTBuilder->setUser('586DB7DF-57C3-F7D5-639D-0A9779AF79BD');


# process the reversal transaction, if no exceptions then we have
# a sucessful transaction.

$oGateway = getGatewayCollection()->getGateway('ledger_transaction');

$oTransaction = $oGateway->selectQuery()
             ->start()
                ->where('transaction_id = :iTransactionId')
                ->setParameter(':iTransactionId',1,'integer')
             ->end()
           ->findOne();

$oTBuilder->processAdjustment($oTransaction);
       
$oAdjTransaction = $oTBuilder->getTransactionHeader();

echo 'Adjustment Transaction ID'  . $oAdjTransaction->iTransactionID;
ehco 'Original Transaction references adj'. $oTransaction->iAdjustmentID;

```

> Should give them replacement transaction the same occured date as the original so if a list is made in date order you see them grouped together.


Run a Trail Balance
----------------------
1. Decide if you want to use the AGG tables or the entry tables.
2. Pick if you want a trail balance for everyone or a single user/organistation unit.

```php
use Doctrine\DBAL\Connection;
use Monolog\Logger;
use Monolog\Handler\TestHandler;
use Symfony\Component\EventDispatcher\EventDispatcher;
use IComeFromTheNet\GeneralLedger\LedgerContainer;
use IComeFromTheNet\GeneralLedger\TrialBalance;
use IComeFromTheNet\GeneralLedger\TrialBalanceOrgUnit;
use IComeFromTheNet\GeneralLedger\TrialBalanceUser;


$oAppLog   = new new Logger('test-ledger',array(new TestHandler()));
$oDatabase = new Connection(array());
$oEvent    = new EventDispatcher();

$oLedgerContainer = new LedgerContainer($oEvent, $oDatabase, $oAppLog);
$oLedgerContainer->boot();

# pick a to date.

$oProcessingDate = new DateTime('now - 1 day') 
$bUseAggSource   = true;
$iOrgUnit        = 1;
$iUser           = 1;

# You need to do a lookup to map human name for User or OrgUnit to database id.

$oTrialBal        = new TrialBalance($oLedgerContainer, $oProcessingDate,$bUseAggSource);
$oUserTrialBal    = new TrialBalanceOrgUnit($oLedgerContainer, $oProcessingDate,$iUser,$bUseAggSource);
$oOrgUnitTrialBal = new TrialBalanceUser($oLedgerContainer, $oProcessingDate,$iOrgUnit,$bUseAggSource);

# execute the balance, will throw and exception if something goes wrong.

$oTrialBalance = $oTrialBal->getTrialBalance();


# print the results

foreach($oTrialBalance => $oLedgerBalance) {
    echo $oLedgerBalance->sAccountNumber;
    echo $oLedgerBalance->sAccountName;
    echo $oLedgerBalance->fDebit;
    echo $oLedgerBalance->fCredit;
    
}


```




