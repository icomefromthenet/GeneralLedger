<?php
use Faker\Extension\Seed\Voucher;
use Faker\Components\Engine\Entity\Builder\EntityGenerator;
use Faker\Components\Engine\Entity\GenericEntity;

//---------------------------------------------------------------
// Setup Voucher Seed
//
//--------------------------------------------------------------

global $project;
$name   = 'voucher';
$locale = $project->getLocaleFactory()->create('en');
$util   = $project->getEngineUtilities();
$gen    = $project->getDefaultRandom();
    
$builder = EntityGenerator::create($project,$name,$locale,$util,$gen);


$voucher = new Voucher($builder,function (GenericEntity $entity) {
            return $entity;
});


# only have 5 journal types define we can only make 5 as base
$baseVouchers = $voucher->make(5);        


//---------------------------------------------------------------
// Define the versioned vouchers
//
//--------------------------------------------------------------



//---------------------------------------------------------------
// Output the Vouchers
//
//--------------------------------------------------------------

$table = new Doctrine\DBAL\Schema\Table('ledger_voucher');
$table->addColumn('voucher_slug','string',array('length'=>150));
$table->addColumn("voucher_enabled_from", "datetime",array());
$table->addColumn("voucher_enabled_to", "datetime",array());
$table->addColumn('voucher_name','string',array('length'=>100));
$table->addColumn('voucher_description','string',array('length'=>500));
$table->addColumn('voucher_prefix','string',array('length'=> 20));
$table->addColumn('voucher_suffix','string',array('length'=>20));
$table->addColumn('voucher_sequence_strategy','string',array('length'=> 20));
$table->addColumn('voucher_sequence_no','integer',array('unsiged'=> true));
$table->addColumn('voucher_sequence_padding_char','string',array('legnth'=>'1'));
$table->addColumn('voucher_formatter','string',array('length'=> 100));
$table->setPrimaryKey(array('voucher_slug','voucher_enabled_from'));

$types = array();

foreach($table->getColumns() as $column) {
    $types[$column->getName()] = $column->getType();
}


foreach($baseVouchers as $result) {
        $r     = $result->toArray();
        
        echo $result->voucher_slug .' :: ' . $result->voucher_enabled_from->format('d/m/Y') . ' - ' . $result->voucher_enabled_to->format('d/m/Y') . PHP_EOL;
        
        # We want type list and column is to have same index order
        # since both index are column names we can just use same sort function.
        ksort($r);          
        ksort($types);
        
        $project->getDatabase()->insert('ledger_voucher',$r,array_values($types));
}



//-------------------------------------------------------------------
// Return null as we using entity generator not PHP Builder Composite
//
//--------------------------------------------------------------------

return null;