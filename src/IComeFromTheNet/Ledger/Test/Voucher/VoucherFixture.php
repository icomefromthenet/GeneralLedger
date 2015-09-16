<?php

return [
     'ledger_voucher_group' => [
        ['voucher_group_id' => null,'voucher_group_name' => 'Group A', 'voucher_group_slug'=> 'group_a' , 'is_disabled' => 0, 'sort_order' => 1 , 'date_created' => date('YYYY-MM-DD HH:MM:SS')],
        ['voucher_group_id' => null,'voucher_group_name' => 'Used in Delete Test', 'voucher_group_slug'=> 'used_in_delete_test' , 'is_disabled' => 0, 'sort_order' => 1 , 'date_created' => date('YYYY-MM-DD HH:MM:SS')],
    ],
    'ledger_voucher_gen_rule' => [
        ['voucher_gen_rule_id' => null, 'voucher_rule_name'   => 'Rule Fixture A' ,'voucher_rule_slug' => 'rule_fixture_a'  , 'voucher_padding_char' => 'a', 'voucher_prefix' => 'a_', 'voucher_suffix' => '_b', 'voucher_length' => 4, 'voucher_sequence_strategy' => 'SEQUENCE', 'date_created' => date('YYYY-MM-DD HH:MM:SS')]
        
    ],
    'ledger_voucher_type' => [
        ['voucher_type_id'      => null
        ,'voucher_enabled_from' => date('YYYY-MM-DD HH:MM:SS')
        ,'voucher_enabled_to'   => date('YYYY-MM-DD HH:MM:SS',mktime(0, 0, 0, date("m")  , date("d")+5, date("Y")))
        ,'voucher_name'         =>  'Fixture Type A'
        ,'voucher_name_slug'    => 'fixture_type_a'
        ,'voucher_description'  => 'Normal voucher type description'
        ,'voucher_group_id'     => 1
        ,'voucher_gen_rule_id'  => 1]
    ],
    'ledger_voucher_instance' => [
        ['voucher_instance_id' => null
         ,'voucher_type_id' => 1
         ,'voucher_code' => 'aaaa_0105' 
         , 'date_created' => date('YYYY-MM-DD HH:MM:SS')
        ]    
    ]

];