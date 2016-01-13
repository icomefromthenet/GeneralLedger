<?php
return [
   
    'ledger_daily' => [
        
       /* Ensure Upsert does not pick wrong date */
       [
            'process_dt' => (new DateTime('now -1 day'))->format('Y-m-d')
            ,'account_id' => 46 
            ,'balance'    => 100.04
       ]
     
       /* Single movement so insert only */  
       ,[
            'process_dt' => (new DateTime('now'))->format('Y-m-d')
            ,'account_id' => 46 
            ,'balance'    => 100.00
       ]
       
       /* Two movements so triggered the upsert and combined the money values */
      ,[
            'process_dt' => (new DateTime('now'))->format('Y-m-d')
            ,'account_id' => 47 
            ,'balance'    => 125.00
       ]
        
    ]
];