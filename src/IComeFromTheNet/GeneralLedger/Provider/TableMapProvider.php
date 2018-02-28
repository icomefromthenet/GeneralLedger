<?php 
namespace IComeFromTheNet\GeneralLedger\Provider;

use Pimple\ServiceProviderInterface;
use Pimple\Container;


class TableMapProvider implements ServiceProviderInterface
{
      
    protected function getDefaultTableMap() 
    {
         return [
             # Accounts
              'ledger_account_group' => 'ledger_account_group'
             ,'ledger_account'       => 'ledger_account'
             
             # Journal / Org Units / Users
             ,'ledger_org_unit'      => 'ledger_org_unit'
             ,'ledger_journal_type'  => 'ledger_journal_type'
             ,'ledger_user'          => 'ledger_user'
             
             # Transaction table
             ,'ledger_transaction'   => 'ledger_transaction'
             ,'ledger_entry'         => 'ledger_entry'
             ,'ledger_daily'         => 'ledger_daily'
             ,'ledger_daily_org'     => 'ledger_daily_org'
             ,'ledger_daily_user'    => 'ledger_daily_user'
             
             
            ];
        
        
    }
  
  
  
    public function register(Container $pimple)
    {
        $pimple['table_map'] = $this->getDefaultTableMap();
    }
  
    
    
    
    
}
/* End of File */