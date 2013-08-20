Ledger
======

Overview
--------

Accounting Event
----------------
When a event occurs that requires a transaction to occur on our general ledger an Accounting Event is raised and sent to the processing engine.

Processing Rules
---------------
These Rules Convert a event into a transaction on the ledger. They are temporal apply at a given date so new rules will override old rules after a given date.


General Ledger
--------------
The made of up of accounts, the ledger is a list of transaction on accounts. Each transaction can have many account movements but must
balance to zero i.e. accounting Equation. 


Accounts
------------
Accounts make up the general ledger, each account can be grouped and generall belong to one of the common types

TYPE        | NORMAL BALANCE    | DESCRIPTION
--------------------------------------------------------------------------
Asset       | Debit             | Resources owned by the Business Entity
Liability   | Credit            | Debts owed to outsiders
Equity      | Credit            | Owners rights to the Assets
Revenue     | Credit            | Increases in owners equity
Expense     | Debit             | Assets or services consumed in the generation of revenue

Accounts bring together common descriptors, like customer, currency, project, etc.