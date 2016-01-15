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
        
        
        /* A normal transaction */    
        ,[
            'transaction_id'   => 2
            ,'journal_type_id' => 1
            ,'adjustment_id'   => null
            ,'org_unit_id'     => 1
            ,'user_id'         => 1
            ,'process_dt'      => (new DateTime('now'))->format('Y-m-d')
            ,'occured_dt'      => (new DateTime('now - 5 day'))->format('Y-m-d')
            ,'vouchernum'      => '10002'
            
        ]
        
        
    ]
    
    ,'ledger_daily' => [
        
        [
            'process_dt' => (new DateTime('now -1 day'))->format('Y-m-d')
            ,'account_id' => 46
            ,'balance'    => 100.04
       ]
        
    ]
    
    ,'ledger_daily_user' => [
        
        [
            'process_dt' => (new DateTime('now -1 day'))->format('Y-m-d')
            ,'account_id' => 46 
            ,'user_id'    => 1
            ,'balance'    => 100.04
        ]   
        
        
    ]
    
    ,'ledger_daily_org' => [
        
        [
            'process_dt' => (new DateTime('now -1 day'))->format('Y-m-d')
            ,'account_id' => 46 
            ,'org_unit_id' => 1
            ,'balance'    => 100.04   
        ]
            
    ]
    
];