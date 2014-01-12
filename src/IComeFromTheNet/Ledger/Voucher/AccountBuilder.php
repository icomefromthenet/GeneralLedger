<?php
namespace IComeFromTheNet\Ledger\Voucher;

use DBALGateway\Builder\BuilderInterface;
use Aura\Marshal\Entity\BuilderInterface as EntityBuilderInterface;
use IComeFromTheNet\Ledger\Voucher\VoucherEntity;
use IComeFromTheNet\Ledger\Voucher\ValidationRuleBag;
use IComeFromTheNet\Ledger\Voucher\Strategy\StrategyFactoryInterface;
use IComeFromTheNet\Ledger\Voucher\FormatterBagInterface;

/**
  *  Builds an Voucher Entity
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class VoucherBuilder implements BuilderInterface,EntityBuilderInterface
{
    
    
    protected $strategyFactory;
    
    protected $formatterBag;
    
    protected $validationRuleBag;
    
    protected $databasePlatform;
    
    public function __construct(FormatterBagInterface $formatterBag,
                                StrategyFactoryInterface $strategyFactory,
                                ValidationRuleBag $ruleBag,
                                databasePlatform $databasePlarform)
    {
        $this->strategyFactory   = $strategyFactory;
        $this->formatterBag      = $formatterBag;
        $this->validationRuleBag = $ruleBag;
        $this->databasePlatform  = $databasePlatform;
    }
    
    
    /**
     * 
     * Creates a new entity object.
     * 
     * @param array $data Data to load into the entity.
     * @return Account
     * @access public
     * 
     */
    public function newInstance(array $data)
    {
        return $this->build($data);
    }
    
    /**
      *  Convert data array into entity
      *
      *  @return Account
      *  @param array $data
      *  @access public
      */
    public function build($data)
    {
        $voucher = new VoucherEntity();
        
        $voucher->setSlug($data['voucher_slug']);
        
        $voucher->setEnabledFrom($data["voucher_enabled_from"]);
        $voucher->setEnabledTo($data["voucher_enabled_to"]);

        $voucher->setName($data['voucher_name']);
        $voucher->setDescription($data['voucher_description']);
        $voucher->setPrefix($data['voucher_prefix']);
        $voucher->setSuffix($data['voucher_suffix']);
        $voucher->setMaxLength($data['voucher_maxlength']);
        $voucher->setPaddingChar($data['voucher_sequence_padding_char']);
        
        # pull the formatter from the bag
        $this->setVoucherFormatter($this->formatterBag->getFormatter($data['voucher_formatter']));
        
        
        # pull sequence strategy from factory.
        $voucher->setSequenceStrategy($this->strategyFactory->getInstance($data['voucher_sequence_strategy'],
                                                                          $this->databasePlatform
                                                                          )
                                    );
        
        # assign the validation rule bag
        $voucher->setValidationRuleBag($this->validationRuleBag);
        
        return $voucher;        
        
    }
    
    /**
      *  Convert and entity into a data array
      *
      *  @return array
      *  @access public
      */
    public function demolish($entity)
    {
       $data = array(
           
        );
        
        return $data;
    }
    
    
}
/* End of Class */
