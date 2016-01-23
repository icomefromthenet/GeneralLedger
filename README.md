GeneralLedger
=============

General Ledger for PHP and MySql.

A [general ledger link](https://www.google.com.au/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8&client=ubuntu#q=define%3Ageneral%20ledger) is a complete record of financial transactions over the life of a company. The ledger holds account information that is needed to prepare financial statements, and includes accounts for assets, liabilities, owners' equity, revenues and expenses.


Installing
---------------

Step 1. You can install this library using composer. 

```json
    icomefromthenet/ledger : 1.0 
```

Step 2. Create a new databased called 'general_ledger' and  run the database build script under database/database.sql

```bash
    mysql general_ledger < database/database.sql
```

> I use my own database migration tool called [Migrations](https://github.com/icomefromthenet/Migrations) but I have included a sql file for convenience.


Terms and conventions
----------------------

Important before looking at this implementation to have an understanding of the accounting terms.


### 1. Debits / Credit.
A Debit is a value with a positive sign, A credit is a value with a negative sign. 

### 2. Transaction
For the purposes of this library a transaction is represent by a single entry into the general ledger with each transaction have 1 to many account movements. 

### 3. Organisation Unit / Cost Center
This is used to group transactions with each having a relation to ONE group. Groups should be mutally exclusive for example departments in an organisation.

### 4. Ledger User.
Each transaction is subscribed to a single user this most likely your application users.

### 5. Ledger Entry / Account movement.
Each entry represent an allocation to a ledger account. 

### 6. Ledger Account
Each account can hold one to many child accounts think of it like a tree data structure an account is both a leaf and a stem.

### 6. Trail Balance
Aggerate of all enteries into a single balance for each account which is then split into debits and credits. The ledger is said to be in balance if debits equals credit. 

### 7. Adjustments
To make a correction a transaction must be adjusted through a reveral and a re-issue we do NOT delete transactions in our ledgers. 


Create a Transaction
---------------------

1. Instance the Library DI Container.
2. Instance the Transaction Builder.
3. Fetch the current date from the database. 

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




# process the transaction.

```





> I do not enforce the processing date to be same as the database, but you really should not assume your webserver and database server running same settings. 
