<?php
return [
    
     'ledger_transaction' => [
        
        /* A normal transaction */    
        [
            'transaction_id'   => 1
            ,'journal_type_id' => 1
            ,'adjustment_id'   => null
            ,'org_unit_id'     => 1
            ,'user_id'         => 1
            ,'process_dt'      => (new DateTime('now'))->format('Y-m-d')
            ,'occured_dt'      => (new DateTime('now - 5 day'))->format('Y-m-d')
            ,'vouchernum'      => '10001'
            
        ]
        
        
        
    ]
    
     ,'ledger_entry' => [
          
          [
            'entry_id'    => 1
            ,'transaction_id' => 1
            ,'account_id' => 4
            ,'movement'  => 300.00
          ]
     
          ,[
            'entry_id'    => 2
            ,'transaction_id' => 1
            ,'account_id' => 5
            ,'movement'  => 200.00
          ]
          
          ,[
            'entry_id'    => 3
            ,'transaction_id' => 1
            ,'account_id' => 6
            ,'movement'  => 40.00
          ]
    ]  
    
];
