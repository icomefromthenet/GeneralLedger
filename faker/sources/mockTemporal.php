<?php

use Faker\Components\Engine\DB\Builder\SchemaBuilder;

//---------------------------------------------------------------
// Define the Composite
//
//--------------------------------------------------------------

$container = $project;
$name      = 'test_db';
$locale    = $container->getLocaleFactory()->create('en');
$util      = $container->getEngineUtilities();
$gen       = $container->getDefaultRandom();
$builder   = SchemaBuilder::create($container,$name,$locale,$util,$gen);

$composite = $builder
            ->describe()
                ->addTable('mock_temporal')
                    ->toGenerate(20)
                    ->addColumn('slug_name')
                        ->dbalType('string')
                        ->addField()
                            ->selectorSwap()
                                ->swapAt(10)
                                    ->fieldClosure()
                                        ->execute(function($rows,$column,$last){
                                            return 'entityA'; 
                                        })
                                    ->end()
                                ->end()
                                ->swapAt(10)
                                    ->fieldClosure()
                                        ->execute(function($rows,$column,$last){
                                            return 'entityB'; 
                                        })
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                    ->addColumn('posting_date')
                        ->dbalType('date')
                        ->addField()
                            ->fieldClosure()
                                ->execute(function($rows,$columns,$last){
                                    
                                    if(!isset($last['posting_date'])) {
                                        return  new DateTime('today');
                                
                                    } else {
                                        $n = clone $last['posting_date'];
                                        return $n->modify('+1 days');    
                                    }
                                    
                                })
                            ->end()
                        ->end()
                    ->end()
                    ->addColumn('enabled_from')
                        ->dbalType('date')
                        ->addField()
                            ->fieldClosure()
                                ->execute(function($rows,$columns,$last){
                                    
                                    if(!isset($last['enabled_to'])) {
                                        return  new DateTime('today');
                                
                                    } else {
                                        $n = clone $last['enabled_to'];
                                        return $n->modify('+1 days');    
                                    }
                                    
                                })
                            ->end()
                        ->end()
                    ->end()
                    ->addColumn('enabled_to')
                        ->dbalType('date')
                        ->addField()
                            ->fieldClosure()
                                ->execute(function($rows,$columns,$last){
                                    $fin = clone $columns['enabled_from'];
                                    return $fin->modify('+7 days');
                                    
                                })
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->addWriter()
                ->phpUnitWritter()
                    ->outputEncoding('utf8')
                        ->outFileFormat('{prefix}_{body}_{suffix}.{ext}')
                ->end()
            ->end()
        ->end();
                
//-------------------------------------------------------------------
// Return null as we using entity generator not PHP Builder Composite
//
//--------------------------------------------------------------------

return $composite;