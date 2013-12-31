<?php
namespace Faker\Extension\Seed;

use Faker\Components\Engine\Entity\Builder\EntityGenerator;
use Faker\Components\Engine\Entity\Builder\FieldCollection;
use Faker\Components\Engine\Common\Builder\NodeBuilder;

/**
 *  Creating a new voucher, Configure A Voucher entity using an EntityGenerator
 *
 *  Sets the fieds from database 
 *
*/
class Voucher
{
 
    const ENTITY_NAME                    = 'voucher';
    const FIELD_VOUCHER_NAME             = 'voucher_name';
    const FIELD_VOUCHER_ENABLED_TO       = 'voucher_enabled_to';
    const FIELD_VOUCHER_ENABLED_FROM     = 'voucher_enabled_from';
    const FIELD_VOUCHER_DESCRIPTION      = 'voucher_description';
    const FIELD_VOUCHER_PREFIX           = 'voucher_prefix';
    const FIELD_VOUCHER_SUFFIX           = 'voucher_suffix';
    const FIELD_VOUCHER_SLUG             = 'voucher_slug';
    const FIELD_VOUCHER_SEQENCE_STRATEGY = 'voucher_sequence_strategy';
    const FIELD_VOUCHER_SEQENCE_NO       = 'voucher_sequence_no';    
    
    
    /**
     * @var Faker\Components\Engine\Entity\Builder\EntityGenerator
    */
    protected $entity;
    
    
    //-------------------------------------------------------
    # Constructor
    
    public function __construct(EntityGenerator $generator, \Closure $formatter)
    {
        $this->entity    = $generator;

        $fieldCollection = $generator->describe();
        
        foreach($this->getFields() as $fieldConstant) {
            $this->callConfigureMethod($fieldConstant,$fieldCollection);
        }
        
        $fieldCollection->end();
        
        $this->entity->map($formatter);

    }
    
    //-------------------------------------------------------
    # Helpers
    
    protected function getFields()
    {
        $oClass = new \ReflectionClass('Faker\Extension\Seed\Voucher');
        
        return array_values(array_filter(array_flip($oClass->getConstants()),function($val) {
           return substr($val, 0, 6) === "FIELD_";
        }));
        
    }

    protected function callConfigureMethod($constant,$builder)
    {
        $split = explode('_', constant("self::$constant"));
        
        if($split[0] === 'FIELD') {
            unset($method[0]);    
        }
        
        $split = array_map(function($val) {
            return ucfirst($val);
        },$split);
        
        $method = 'configure'. implode($split,'');
        if(!method_exists($this,$method)) {
            throw new \RuntimeException("Method::$method does not exist");
        }
        
        $this->$method($builder);
        
        return $this;
    }
    
    
    protected function getVoucherNames()
    {
        return array(
          'sales recepit',
          'journal',
          'invoice',
          'tax invoice',
          'travel voucher'
        );
    }
    
    protected function getSequenceStrategies()
    {
        return array(
          'uuid',
          'sequence'
        );

    }
    
    
    //-------------------------------------------------------
    #  Methods configure the fields for the entity
    
    
    protected function configureVoucherName(FieldCollection $builder)
    {
        
        $builder->addField(self::FIELD_VOUCHER_NAME)
                    ->selectorAlternate()
                        ->step(1)
                        ->describe()
                            ->each($this->getVoucherNames(),function($v,NodeBuilder $builder){
                                    $builder->fieldConstant()
                                        ->value($v)
                                        ->cast('string')
                                    ->end();
                            })
                        ->end() 
                    ->end()
                ->end();
                
        return $builder;
    }
    
    protected function configureVoucherDescription(FieldCollection $builder)
    {
        
        $builder->addField(self::FIELD_VOUCHER_DESCRIPTION)
                 ->fieldRegex()
                    ->regex('[a-zA-Z]{10,500}')
                 ->end()
               ->end();
        
        return $builder;
    }
    
    protected function configureVoucherPrefix(FieldCollection $builder)
    {
        $builder->addField(self::FIELD_VOUCHER_PREFIX)
                 ->fieldRegex()
                    ->regex('[a-zA-Z]{5,20}')
                 ->end()
               ->end();
        
        return $builder;
    }
    
    
    protected function configureVoucherSuffix(FieldCollection $builder)
    {
        $builder->addField(self::FIELD_VOUCHER_SUFFIX)
                 ->fieldRegex()
                    ->regex('[a-zA-Z]{5,20}')
                 ->end()
               ->end();
        
        return $builder;
    }
    
    
    protected function configureVoucherSequenceStrategy(FieldCollection $builder)
    {
        $builder->addField(self::FIELD_VOUCHER_SEQENCE_STRATEGY)
                ->selectorRandom()
                  ->describe()
                   ->each($this->getSequenceStrategies(),function($value, NodeBuilder $builder){
                         $builder->fieldConstant()
                            ->cast('string')
                            ->value($value) 
                        ->end();
                    })
                  ->end()
                ->end()
            ->end();
        
        return $builder;
    }
    
    protected function configureVoucherSequenceNo(FieldCollection $builder)
    {
        $builder->addField(self::FIELD_VOUCHER_SEQENCE_NO)
                ->fieldNumeric()
                  ->format('XXX')
                ->end()
         ->end();
        
        return $builder;
    }
    
    public function configureVoucherEnabledFrom(FieldCollection $builder)
    {
        $builder->addField(self::FIELD_VOUCHER_ENABLED_FROM)
            ->selectorWeightAlternate()
                ->weight(0.3)
                ->describe()
                    ->fieldDate()
                        ->startDate(new \DateTime('01-01-2013')) 
                    ->end()
                    ->fieldDate()
                        ->startDate(new \DateTime('01-06-2013')) 
                    ->end()
                ->end()
            ->end()
        ->end();
                
        return $builder;
    }
    
    
    public function configureVoucherEnabledTo(FieldCollection $builder)
    {
        $builder->addField(self::FIELD_VOUCHER_ENABLED_TO)
            ->fieldDate()
                ->startDate(new \DateTime('01-01-3000')) //max date year 3000
            ->end()
        ->end();
        
        
        return $builder;
    }
    
    public function configureVoucherSlug(FieldCollection $builder)
    {
        
        $name = self::FIELD_VOUCHER_NAME;
        
        $builder->addField(self::FIELD_VOUCHER_SLUG)
            ->fieldClosure()
              ->execute(function($rows,$values) use ($name) {

                    if(!isset($values[$name])) {
                        throw new \RuntimeException('Voucher name field not set');
                    }
                    
                    return str_replace(' ', '_',strtolower($values[$name]));
                })
            ->end()
        ->end();
        
        return $builder;
    }
    
    
    /**
     *  Return a collection of voucher GenericEntities
     *
     *  @access public
     *  @return  Faker\Components\Engine\Entity\EntityIterator
     *
    */
    public function make($number)
    {
        return $this->entity->fake($number);
    }
    
}
/* End of Class */

