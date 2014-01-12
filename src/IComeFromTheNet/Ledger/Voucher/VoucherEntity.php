<?php
namespace IComeFromTheNet\Ledger\Voucher;

use DateTime;
use Aura\Marshal\Entity\GenericEntity;
use IComeFromTheNet\Ledger\Exception\LedgerException;
use IComeFromTheNet\Ledger\Voucher\Formatter\FormatterInterface;
use IComeFromTheNet\Ledger\Voucher\Strategy\SequenceStrategyInterface;
use IComeFromTheNet\Ledger\Voucher\ValidationRuleBag;

/**
  *  Represent a custom Ledger Entry type.
  *
  *  Ledger transaction are often divied into groups, for example
  *
  *  1. General Journals
  *  2. Sales Recepits
  *  3. Invoices
  *  4. etc
  *
  *  As we can't know every group (voucher type) this entity allows
  *  developers to define their own and relate them back to a ledger transaction.
  *
  *  Each voucher is identified by a 'voucher reference'
  *
  *  {prefix}sequence{suffix}
  *
  *  e.g GL_503
  *
  *  Types may share common name and slug but will have a different
  *  enabled date pair.
  *
  *  If change the prefix for sales recepits, that is a new type with
  *  same name.
  *
  *  A voucher slug name is used to establish relationships in the domain.
  *  The ledger will only load the valid entities as of the given date and
  *  for each name there can be only one valid entity.
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class VoucherEntity extends GenericEntity
{
    const DESCRIPTION_MAX_SIZE  = 500;
    const NAME_MAX_SIZE         = 100;
    
    
    const FIELD_NAME             = 'voucher_name';
    const FIELD_DESCRIPTION      = 'voucher_description';
    const FIELD_ENABLE_FROM      = 'voucher_enable_from';
    const FIELD_ENABLE_TO        = 'voucher_enable_to';
    const FIELD_PREFIX           = 'voucher_prefix';
    const FIELD_SUFFIX           = 'voucher_suffix';
    const FIELD_MAXLENGTH        = 'voucher_maxlength';
    const FIELD_SLUG             = 'voucher_slug';
    
    
    public function __construct()
    {
        $this->__set(self::FIELD_NAME,null);
        $this->__set(self::FIELD_DESCRIPTION,null);
        $this->__set(self::FIELD_ENABLE_FROM,null);
        $this->__set(self::FIELD_ENABLE_TO,null);
        $this->__set(self::FIELD_PREFIX,null);
        $this->__set(self::FIELD_SUFFIX,null);
        $this->__set(self::FIELD_MAXLENGTH,null);
        $this->__set(self::FIELD_SLUG,null);
        
    }
    
    
     /**
     *  Gets the voucher slug name (database_id)
     *
     *  @access public
     *  @return string the slug
     *
    */
    public function getSlug()
    {
        return $this->__get(self::FIELD_SLUG);
    }
    
    /**
     *  Set the voucher slug name (database id)
     *
     *  @access public
     *  @return $this
     *  @param string $slug the database identity
     *
    */
    public function setSlug($slug)
    {
        if(empty($slug)) {
            throw new LedgerException('Voucher slug must not be empty');
        }
    
        
        $this->__set(self::FIELD_SLUG,$slug);
        return $this;
    }
    
    /**
     *  Return this voucher types name
     *
     *  @access public
     *  @return string
     *
    */
    public function getName()
    {
        return $this->__get(self::FIELD_NAME);
    }
    
    /**
     *  Set a name for this voucher type, must not be empty
     *
     *  @access public
     *  @return $this
     *  @param string $name max 100 characters
     *
    */
    public function setName($name)
    {
        if(empty($name)) {
            throw new LedgerException('Voucher name must not be empty');
        }
        
        $this->__set(self::FIELD_NAME,$name);
        
        return $this;
    }
    
    /**
     *  Sets the description of this voucher type
     *
     *  @access public
     *  @return void
     *
    */
    public function getDescription()
    {
        return $this->__get(self::FIELD_DESCRIPTION);   
    }
    
    /**
     *  Sets a description for this voucher type
     *
     *  @access public
     *  @return $this
     *  @param string $description max 500 characters
     *
    */
    public function setDescription($description)
    {
     
        $this->__set(self::FIELD_DESCRIPTION,$description);
        
        return $this;
    }
    
    
    /**
     *  Get the date this voucher Type will be available from
     *
     *  @access public
     *  @return DateTime
     *
    */
    public function getEnabledFrom()
    {
        return $this->__get(self::FIELD_ENABLE_FROM);
    }
    
    /**
     *  Set date this voucher Type will be available from
     *
     *  @access public
     *  @return $this
     *  @param DateTime $from
     *
    */
    public function setEnabledFrom(DateTime $from)
    {
         $closed = $this->__get(self::FIELD_ENABLE_TO);
        
        if($closed instanceof DateTime) {
            if($closed <= $from) {
                throw new LedgerException('Date the voucher becomes available must occur before the assigned unavailable date');
            }
        }
        
        $this->__set(self::FIELD_ENABLE_FROM,$from);
        
        return $this;
    }
    
    
    /**
     *  Gets the date this voucher type will be unavailable.
     *
     *  @access public
     *  @return DateTime
     *
    */
    public function getEnabledTo()
    {
        return $this->__get(self::FIELD_ENABLE_TO);
    }
    
    /**
     *  Sets the date this voucher type will be unavailable.
     *
     *  i.e. soft delete.
     *
     *  @access public
     *  @return $this
     *  @param DateTime $to 
     *
    */    
    public function setEnabledTo(DateTime $to)
    {
        $opened = $this->__get(self::FIELD_ENABLE_FROM);
        
        if($opened instanceof DateTime) {
            if($opened >= $to) {
                throw new LedgerException('Date the voucher becomes unavailable must occur after the assigned available date');
            }
        }
        
        
        $this->__set(self::FIELD_ENABLE_TO,$to);
        
        return $this;
    }
    
    
    /**
     *  Gets the prefix that attached start of a voucher reference
     *
     *  @access public
     *  @return void
     *
    */
    public function getPrefix()
    {
        return $this->__get(self::FIELD_PREFIX);
    }
    
    /**
     *  Sets a prefix that attached to start of a voucher reference
     *
     *  @access public
     *  @return $this;
     *  @param string $prefix
     *
    */
    public function setPrefix($prefix)
    {
        $this->__set(self::FIELD_PREFIX,$prefix);
        return $this;
    }
    
    /**
     *  Get the suffix that attached to voucher reference
     *
     *  @access public
     *  @return string the suffix
     *
    */
    public function  getSuffix()
    {
        return $this->__get(self::FIELD_SUFFIX);
    }
    
    /**
     *  Sets a suffix to attach to end of a voucher reference
     *
     *  @access public
     *  @return $this;
     *  @param string $suffix
     *
    */
    public function setSuffix($suffix)
    {
        $this->__set(self::FIELD_SUFFIX,$suffix);
        return $this;
    }
    
    /**
     *  Sets the MaxLength of a reference field
     *
     *  @access public
     *  @return integer field length | null for no max
     *
    */
    public function getMaxLength()
    {
        return $this->__get(self::FIELD_MAXLENGTH);        
    }
    
    /**
     *  The maxlength of the reference field
     *
     *  can me null for no max
     *
     *  @access public
     *  @param integer | null $max
     *
    */
    public function setMaxLength($max)
    {
        $this->__set(self::FIELD_MAXLENGTH,$max);
        return $this;
    }
    
    
    //----------------------------------------------------------------
    # Object Properties 
    
    protected $voucherFormatter;
    protected $sequenceStrategy;
    protected $validationRuleBag;
    
    /**
     *  Gets the voucher formatter
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\Voucher\Formatter\FormatterInterface
     *
    */
    public function getVoucherFormatter()
    {
        return $this->voucherFormatter;    
    }
    
    /**
     *  Sets the class that format the generated sequence
     *
     *  @access public
     *  @return VoucherEntity
     *  @param IComeFromTheNet\Ledger\Voucher\Formatter\FormatterInterface $formatter
     *
    */
    public function setVoucherFormatter(FormatterInterface $formatter)
    {
        $this->voucherFormatter = $formatter;
        return $this;
    }
    
    /**
     *  Get the class that generate the sequence.
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\Voucher\Strategy\SequenceStrategyInterface
     *
    */
    public function getSequenceStrategy()
    {
        return $this->sequenceStrategy;
    }
    
    /**
     *  Set the class that generate the sequence
     *
     *  @access public
     *  @return VoucherEntity
     *  @param IComeFromTheNet\Ledger\Voucher\Strategy\SequenceStrategyInterface $sequenceStrategy
     *
    */
    public function setSequenceStrategy(SequenceStrategyInterface $sequenceStrategy)
    {
        $this->sequenceStrategy = $sequenceStrategy;
        return $this;
    }
    
    /**
     *  Gets the sequence validator rule set
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\Voucher\ValidationRuleBag
     *
    */
    public function getValidationRuleBag()
    {
        return $this->validationRuleBag;
    }
    
    /**
     *  Sets the sequence valdiator rule set
     *
     *  @access public
     *  @return VoucherEntity
     *  @param IComeFromTheNet\Ledger\Voucher\ValidationRuleBag $bag
     *
    */
    public function setValidationRuleBag(ValidationRuleBag $bag)
    {
        $this->validationRuleBag = $bag;
        return $this;
    }
    
    
    //-------------------------------------------------------
    
    /**
     *  Generate a reference and test it is valid
     *
     *  @access public
     *  @return void
     *
    */
    public function generateReference()
    {
        $reference = $this->getVoucherFormatter()->format($this->getSequenceStrategy()->nextVal($this->getSlug()));
        
        if(!$this->validateReference($reference)) {
            throw new LedgerException('Generated reference failed to validate, maybe sequence is broken');
        }
        
        return $reference;
    }
    
    /**
     *  Validate a reference with matching rule
     *
     *  @access public
     *  @return true if valid
     *
    */
    public function validateReference($reference)
    {
        $valid = true;
        
        foreach($this->getValidationRuleBag() as $rule) {
            if(!$rule->validate($reference)){
                $valid = false;
                break;
            };
        }
    
        return $valid;
    }
    
}
/* End of Class */
