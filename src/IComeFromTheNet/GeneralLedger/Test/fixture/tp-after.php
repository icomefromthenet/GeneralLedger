<?php
return [
    
    
    'ledger_transaction' => [
        
         /* A past trancation transaction */    
        [
            'transaction_id'   => 1
            ,'journal_type_id' => 1
            ,'adjustment_id'   => null
            ,'org_unit_id'     => 1
            ,'user_id'         => 1
            ,'process_dt'      => (new DateTime('now -1 day'))->format('Y-m-d')
            ,'occured_dt'      => (new DateTime('now - 5 day'))->format('Y-m-d')
            ,'vouchernum'      => '10001'
            
        ]
         /* A new transaction */    
        ,[
            'transaction_id'   => 2
            ,'journal_type_id' => 1
            ,'adjustment_id'   => 3
            ,'org_unit_id'     => 1
            ,'user_id'         => 1
            ,'process_dt'      => (new DateTime('now'))->format('Y-m-d')
            ,'occured_dt'      => (new DateTime('now - 5 day'))->format('Y-m-d')
            ,'vouchernum'      => '10002'
            
        ]
        
        /* A Reversal transaction */    
        ,[
            'transaction_id'   => 3
            ,'journal_type_id' => 1
            ,'adjustment_id'   => null
            ,'org_unit_id'     => 1
            ,'user_id'         => 1
            ,'process_dt'      => (new DateTime('now'))->format('Y-m-d')
            ,'occured_dt'      => (new DateTime('now - 5 day'))->format('Y-m-d')
            ,'vouchernum'      => '10003'
            
        ]
       
    ]
    
    ,'ledger_entry' => [
        
        [
            'entry_id'       => 1
            ,'transaction_id' => 1
            ,'account_id'    => 1 
            ,'movement'      => 100
        ]
        
        /* New Movements */
        ,[
            'entry_id'       => 2
            ,'transaction_id' => 2
            ,'account_id'    => 46 
            ,'movement'      => 100.00
        ]
        
        ,[
            'entry_id'       => 3
            ,'transaction_id' => 2
            ,'account_id'    => 47
            ,'movement'      => 20.00
        ]
        
        ,[
            'entry_id'       => 4
            ,'transaction_id' => 2
            ,'account_id'    => 47
            ,'movement'      => 105.00
        ]
        
        /* Reversal Transactions */
        ,[
            'entry_id'       => 5
            ,'transaction_id' => 3
            ,'account_id'    => 46 
            ,'movement'      => -100.00
        ]
        
        ,[
            'entry_id'       => 6
            ,'transaction_id' => 3
            ,'account_id'    => 47
            ,'movement'      => -20.00
        ]
        
        ,[
            'entry_id'       => 7
            ,'transaction_id' => 3
            ,'account_id'    => 47
            ,'movement'      => -105.00
        ]
    ]
   
    
];