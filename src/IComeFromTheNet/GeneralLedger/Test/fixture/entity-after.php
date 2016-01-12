<?php
return [
   
    'ledger_account' => [
    
        /* A root Account */
        [
             'account_id'        => 1    
            ,'account_number'   => '1-0000'
            ,'account_name'     => 'Root Account'
            ,'account_name_slug'=> 'root_account'
            ,'hide_ui'          => 0
            ,'is_left'          => 0
            ,'is_right'         => 0
            
        ]
        
        /* Account that can be updated */
        ,[
            'account_id'        => 2    
            ,'account_number'   => '1-0001'
            ,'account_name'     => 'Updated Account'
            ,'account_name_slug'=> 'updated_account'
            ,'hide_ui'          => 1
            ,'is_left'          => 1
            ,'is_right'         => 0
        ]
      
      
        
         /* Account that cannot be removed */
        ,[
            'account_id'        => 4    
            ,'account_number'   => '1-0003'
            ,'account_name'     => 'Account to Cant Remove'
            ,'account_name_slug'=> 'account_to_cant_remove'
            ,'hide_ui'          => 0
            ,'is_left'          => 1
            ,'is_right'         => 0
        ]
        
        /* A New Account */
        ,[
            'account_id'        => 5
            ,'account_number'   => '1-0004'
            ,'account_name'     => 'Example Account 1'
            ,'account_name_slug'=> 'example_account_1'
            ,'hide_ui'          => 0
            ,'is_left'          => 1
            ,'is_right'         => 0
        ]
        
       
        
    ] 
    
    ,'ledger_account_group' => [
          ['child_account_id'  => 2,'parent_account_id' => 1]
         ,['child_account_id'  => 4,'parent_account_id' => 1]
    ]
    
     ,'ledger_journal_type' => [
        
        /* A normal Journal */
        [
            'journal_type_id' =>  1
            ,'journal_name'  => 'Basic Journal'
            ,'journal_name_slug' => 'basic_journal'
            ,'hide_ui' => 0
        ]
        
         /* A journal to be updated */
       , [
             'journal_type_id' =>  3
            ,'journal_name'  => 'Updated Journal'
            ,'journal_name_slug' => 'updated_journal'
            ,'hide_ui' => 1
        ]
        
          /* A journal created */
       , [
             'journal_type_id' =>  4
            ,'journal_name'  => 'New Created'
            ,'journal_name_slug' => 'new_created'
            ,'hide_ui' => 0 
        ]
        
    ]
    
    ,'ledger_org_unit' => [
    
        /* A normal Org Unit */
        [
             'org_unit_id' => 1
            ,'org_unit_name' => 'Normal Org Unit'
            ,'org_unit_name_slug' => 'normal_org_unit'
            ,'hide_ui' => 0
        ]
    
        /* A unit to be removed */
    
        
        /* A Unit to be updated */    
        ,[
             'org_unit_id' => 3
            ,'org_unit_name' => 'Updated Org Unit'
            ,'org_unit_name_slug' => 'updated_org_unit'
            ,'hide_ui' => 1
        ]
        
        /* A unit created */
        
        ,[
             'org_unit_id' => 4
            ,'org_unit_name' => 'New Org Unit'
            ,'org_unit_name_slug' => 'new_org_unit'
            ,'hide_ui' => 0
        ]
    
        
    ]
    ,'ledger_user' => [
        
        /* A normal user */
        [
             'user_id'      => 1
            ,'external_guid'=> '586DB7DF-57C3-F7D5-639D-0A9779AF79BD'
            ,'rego_date'    => (new DateTime('now - 1 day'))->format('Y-m-d 00:00:00')
        ]
        
        /* A user to be removed */
        
        /* A user created */
        ,[
             'user_id'      => 3
            ,'external_guid'=> '6E34457C-BF12-20A0-AEC8-B8FE436CE304'
            ,'rego_date'    => (new DateTime('now - 9 day'))->format('Y-m-d 00:00:00')
        ]
        
    ]
    
    ,'ledger_transaction' => [
        
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
        
        
        /* A transaction to be adjusted */
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
        
        
        /* An adjustment transaction */
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
        
        /* A new Transaction */
        ,[
            'transaction_id'   => 4
            ,'journal_type_id' => 1
            ,'adjustment_id'   => null
            ,'org_unit_id'     => 1
            ,'user_id'         => 1
            ,'process_dt'      => (new DateTime('now'))->format('Y-m-d')
            ,'occured_dt'      => (new DateTime('now - 10 day'))->format('Y-m-d')
            ,'vouchernum'      => '10004'
            
        ]
        
    ]
    
    ,'ledger_entry' => [
          
          /* Normal Entry */
          [
            'entry_id'    => 1
            ,'transaction_id' => 1
            ,'account_id' => 4
            ,'movement'  => 300.00
          ],
         
         /* Entry Created */
          [
            'entry_id'    => 2
            ,'transaction_id' => 1
            ,'account_id' => 4
            ,'movement'  => 100.00
          ]
    ]
    
];