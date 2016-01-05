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
            ,'account_name'     => 'Account to Update'
            ,'account_name_slug'=> 'account_to_update'
            ,'hide_ui'          => 0
            ,'is_left'          => 0
            ,'is_right'         => 1
        ]
      
      
        
         /* Account that cannot be removed */
        ,[
            'account_id'        => 4    
            ,'account_number'   => '1-0003'
            ,'account_name'     => 'Account to Cant Remove'
            ,'account_name_slug'=> 'account_to_cant_remove'
            ,'hide_ui'          => 0
            ,'is_left'          => 0
            ,'is_right'         => 1
        ]
        
    ] 
    
    ,'ledger_account_group' => [
          ['child_account_id'  => 2,'parent_account_id' => 1]
         ,['child_account_id'  => 4,'parent_account_id' => 1]
    ]
    
];