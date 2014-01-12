<?php
namespace IComeFromTheNet\Ledger\Voucher;

use IteratorAggregate;
use IComeFromTheNet\Ledger\Exception\LedgerException;

/**
 *  Provides an interface to select a validation rule from
 *  those registered by the ServiceProvider using the
 *  voucherSlug (voucher name with slug formatter applied)
 *
 *  @author Lewis Dyer <getintouch@icomefromthenet.com>
 *  @since 1.0.0
 *
*/
class ValidationRuleBag implements IteratorAggregate 
{
    

    protected $rules = array();
    
 
    /**
     *  Fetch a validation rule given a slug
     *
     *  @access public
     *  @return ValidationRuleInterface|null rule if found
     *  @param string $ruleName the name of the rule 
     *
    */
    public function getRule($ruleName)
    {
        $rule = null;
        if(isset($this->rules[$ruleName])) {
            $rule = $this->rules[$ruleName];
        }
        
        return $rule;
    }
 
    /**
     *  Add a validiation rule to the bag
     *
     *  @access public
     *  @return $this
     *  @param string $ruleName the name to index rule with
     *  @param ValidationRuleInterface $rule the instanced rule to bind name to
     *
    */
    public function addRule(ValidationRuleInterface $rule)
    {
        $ruleName = $rule->getName();
        
        if(isset($this->rules[$ruleName])) {
            throw new LedgerException("$ruleName already been added to the Rule Bag");
        }
        
        $this->rules[$ruleName] = $rule;
        
        return $this;
    }
    
    /**
     *  Remove a rule from the bag
     *
     *  @access public
     *  @return $this
     *  @param string $ruleName slug of the rule to remove from bag
     *
    */
    public function removeRule($ruleName)
    {
        
        if(isset($this->rules[$ruleName])) {
            unset($this->rules[$ruleName]);
        }
        return $this;
    }
 
    //-------------------------------------------------------
    # IteratorAggregate Interface
    
    
    public function getIterator()
    {
        return new \ArrayIterator($this->rules);
    }
    
}
/* End of File */