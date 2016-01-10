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
    
];