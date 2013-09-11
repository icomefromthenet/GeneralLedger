<?php
namespace IComeFromTheNet\Ledger;

use DateTime;
use IComeFromTheNet\Ledger\Builder\AccountGroupNode;
use IComeFromTheNet\Ledger\Builder\RootGroupBuilder;

/**
  *  Creates a list of accounts for the installer
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class AccountsList
{
    public function getAccounts(DateTime $now)
    {
        $rootNode = new AccountGroupNode(array('id'=>1));
        $builder  = new RootGroupBuilder($rootNode,$now);
            
        # Debit accounts belong on the left of the accounting equation
        # Credit accounts belong on the right of the accounting equation
        # Extened Accounting Equation:  Assets + Expenses = Equity + Liabilities + Income 
            
        # Using Accounts developed by National Standard Chart of Accounts
        # From http://www.coag.gov.au/node/63
            
        return $builder
                    ->debit()
                        ->addGroup()
                            ->groupName('Asset')
                            ->groupDescription('Container for asset accounts')
                            ->addGroup()
                                ->groupName('Current Assets')
                                ->groupDescription('Container for current asset accounts')
                                
                                ->addAccount()
                                    ->accountName('Cash at Bank - Restricted')
                                    ->accountNumber(1110)
                                ->end()
                                ->addAccount()
                                    ->accountName('Cash at Bank - Unrestricted')
                                    ->accountNumber(1120)
                                ->end()
                                ->addAccount()
                                    ->accountName('Petty Cash')
                                    ->accountNumber(1140)
                                ->end()
                                ->addAccount()
                                    ->accountName('Cash Float')
                                    ->accountNumber(1150)
                                ->end()
                                ->addAccount()
                                    ->accountName('Undeposited Funds')
                                    ->accountNumber(1160)
                                ->end()
                                ->addAccount()
                                    ->accountName('Short - Term Investments')
                                    ->accountNumber(1170)
                                ->end()
                                ->addAccount()
                                    ->accountName('Prepayments')
                                    ->accountNumber(1180)
                                ->end()
                                ->addAccount()
                                    ->accountName('Accrued Income')
                                    ->accountNumber(1190)
                                ->end()
                                ->addAccount()
                                    ->accountName('Other Financial Assets')
                                    ->accountNumber(1200)
                                ->end()
                                ->addAccount()
                                    ->accountName('Accounts Receivable')
                                    ->accountNumber(1210)
                                ->end()
                                ->addAccount()
                                    ->accountName('Less: Provision for Doubtful Debts')
                                    ->accountNumber(1220)
                                ->end()
                                ->addAccount()
                                    ->accountName('Accounts Receivable - Rental Debtors')
                                    ->accountNumber(1230)
                                ->end()
                                ->addAccount()
                                    ->accountName('Less: Provision for Doubtful Debts - Rental Debtors')
                                    ->accountNumber(1240)
                                ->end()
                                ->addAccount()
                                    ->accountName('Other Debtors')
                                    ->accountNumber(1250)
                                ->end()
                                ->addAccount()
                                    ->accountName('Less: Provision for Doubtful Debts - OtherDebtors')
                                    ->accountNumber(1260)
                                ->end()
                                ->addAccount()
                                    ->accountName('Inventory on Hand')
                                    ->accountNumber(1300)
                                ->end()
                                ->addAccount()
                                    ->accountName('Other Current Assets')
                                    ->accountNumber(1400)
                                ->end()
                                ->addAccount()
                                    ->accountName('ABN Withholding Credits')
                                    ->accountNumber(1500)
                                ->end()
                            ->end()
                            ->addGroup()
                                ->groupName('Non-Current Assets')
                                ->groupDescription('Container for non current assets')
                                
                                ->addAccount()
                                    ->accountName('Long - Term Investments')
                                    ->accountNumber(5100)
                                ->end()
                                ->addAccount()
                                    ->accountName('Other Financial Assets')
                                    ->accountNumber(5150)
                                ->end()
                                
                                
                            ->end()
                        ->end()
                        ->addGroup()
                            ->groupName('Expense')
                            ->groupDescription('Container for expense accounts')
                        ->end()
                   ->end()
                   ->credit()
                        ->addGroup()
                            ->groupName('Equity')
                            ->groupDescription('Container for equity accounts')
                        ->end()
                        ->addGroup()
                            ->groupName('Liability')
                            ->groupDescription('Container for liabilty accounts')
                        ->end()
                        ->addGroup()
                            ->groupName('Income')
                            ->groupDescription('Container for Income accounts')
                        ->end()
                   ->end()
            ->end();
    }
}
/* End of Class */


