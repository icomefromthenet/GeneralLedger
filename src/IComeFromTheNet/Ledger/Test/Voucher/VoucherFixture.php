<?php

return [
     'ledger_voucher_group' => [
        ['voucher_group_id' => null,'voucher_group_name' => 'Group A', 'voucher_group_slug'=> 'group_a' , 'is_disabled' => 0, 'sort_order' => 1 , 'date_created' => date('YYYY-MM-DD HH:MM:SS')],
    ],
    'ledger_voucher_gen_rule' => [
        ['voucher_gen_rule_id' => null, 'voucher_rule_name'   => 'Rule Fixture A' ,'voucher_rule_slug' => 'rule_fixture_a'  , 'voucher_padding_char' => 'a', 'voucher_prefix' => 'a_', 'voucher_suffix' => '_b', 'voucher_length' => 4, 'voucher_sequence_strategy' => 'SEQUENCE', 'date_created' => date('YYYY-MM-DD HH:MM:SS')]
        
    ]

];