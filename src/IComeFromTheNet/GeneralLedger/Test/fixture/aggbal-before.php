<?php
return [
    
    
    'ledger_daily' => [
        
        [
            'process_dt' => (new DateTime('now -1 day'))->format('Y-m-d')
            ,'account_id' => 46
            ,'balance'    => 100.04
        ]
        ,[
            'process_dt' => (new DateTime('now -1 day'))->format('Y-m-d')
            ,'account_id' => 47
            ,'balance'    => 50
        ]
        ,[
            'process_dt' => (new DateTime('now'))->format('Y-m-d')
            ,'account_id' => 46
            ,'balance'    => 34
        ]
        ,[
            'process_dt' => (new DateTime('now'))->format('Y-m-d')
            ,'account_id' => 47
            ,'balance'    => 56.78
        ]
        ,[
            'process_dt' => (new DateTime('now +1 day'))->format('Y-m-d')
            ,'account_id' => 46
            ,'balance'    => 12
        ]
        ,[
            'process_dt' => (new DateTime('now +1 day'))->format('Y-m-d')
            ,'account_id' => 47
            ,'balance'    => 32
        ]
    ]
    
    ,'ledger_daily_user' => [
        
       [
            'process_dt' => (new DateTime('now -1 day'))->format('Y-m-d')
            ,'account_id' => 46
            ,'balance'    => 100.04
            ,'user_id'     => 1
        ]
        ,[
            'process_dt' => (new DateTime('now -1 day'))->format('Y-m-d')
            ,'account_id' => 47
            ,'balance'    => 50
            ,'user_id'     => 1
        ]
        ,[
            'process_dt' => (new DateTime('now'))->format('Y-m-d')
            ,'account_id' => 46
            ,'balance'    => 34
            ,'user_id'     => 1
        ]
        ,[
            'process_dt' => (new DateTime('now'))->format('Y-m-d')
            ,'account_id' => 47
            ,'balance'    => 56.78
            ,'user_id'     => 1
        ]
        ,[
            'process_dt' => (new DateTime('now +1 day'))->format('Y-m-d')
            ,'account_id' => 46
            ,'balance'    => 12
            ,'user_id'     => 1
        ]
        ,[
            'process_dt' => (new DateTime('now +1 day'))->format('Y-m-d')
            ,'account_id' => 47
            ,'balance'    => 32
            ,'user_id'     => 1
        ]
        
        
    ]
    
    ,'ledger_daily_org' => [
        
        [
            'process_dt' => (new DateTime('now -1 day'))->format('Y-m-d')
            ,'account_id' => 46
            ,'balance'    => 100.04
             ,'org_unit_id' => 1
        ]
        ,[
            'process_dt' => (new DateTime('now -1 day'))->format('Y-m-d')
            ,'account_id' => 47
            ,'balance'    => 50
             ,'org_unit_id' => 1
        ]
        ,[
            'process_dt' => (new DateTime('now'))->format('Y-m-d')
            ,'account_id' => 46
            ,'balance'    => 34
             ,'org_unit_id' => 1
        ]
        ,[
            'process_dt' => (new DateTime('now'))->format('Y-m-d')
            ,'account_id' => 47
            ,'balance'    => 56.78
             ,'org_unit_id' => 1
        ]
        ,[
            'process_dt' => (new DateTime('now +1 day'))->format('Y-m-d')
            ,'account_id' => 46
            ,'balance'    => 12
             ,'org_unit_id' => 1
        ]
        ,[
            'process_dt' => (new DateTime('now +1 day'))->format('Y-m-d')
            ,'account_id' => 47
            ,'balance'    => 32
             ,'org_unit_id' => 1
        ]
    ]  
    
    
];
