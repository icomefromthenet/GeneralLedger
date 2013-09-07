<?php
namespace IComeFromTheNet\Ledger\Processing;

use DateTime;
use IComeFromTheNet\Ledger\Exception\LedgerException;
use IComeFromTheNet\Ledger\Processing\RuleChainInterface;
use IComeFromTheNet\Ledger\Processing\TransactionContext;
use IComeFromTheNet\Ledger\Processing\ErrorCollection;
use Doctrine\Common\Collections\Collection as CollectionInterface;

/**
  *  Allows rules to be grouped
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class RuleChain implements RuleChainInterface, PostingRuleInterface
{
    
    protected $stopOnFirstException  = true;
    
    protected $processEntireChain   = true;
    
    /*
     * @var Doctrine\Common\Collections\Collection a collection of PostingRules
     */
    protected $rules;
    
    /**
     * @var DateTime time after where chain can be applied
    */
    protected $applyDate;
    
    /**
     *  Class Constructor
     *
     *  @access public
     *  @return void
     *
    */
    public function __construct(DateTime $applyDate, CollectionInterface $rulesCollection,$stopOnFirstException = true, $processEntireChain = true)
    {
        $this->applyDate            = $applyDate;
        $this->rules                = $rulesColection;
        $this->stopOnFirstException = (boolean) $stopOnFirstException;
        $this->processEntireChain   = (boolean) $processEntireChain;
        
    }
    
    // --------------------------------------------------------
    # PostingRuleInterface
    
    /**
     *  @inheritdoc
    */
    public function execute(TransactionContext $context, ErrorCollection $errors)
    {
        if(count($this->rules) === 0) {
            throw new LedgerException('There are 0 PostingRules to Process in the chain must be atleast 1');
        }
        
        foreach($this->rules as $rule) {
            
            try {
                if($rule->isApplicable($context)) {
                    $rule->execute($context,$errors);
                    
                    if($this->getProcessingMode() === false) {
                        break;
                    }
                }
            
            }
            catch(LedgerException $e)
            {
                $errors->registerException(get_class($rule),$e);
                
                if($this->getErrorMode() === true) {
                    break;
                }
            
            }
            
        }
    }
    
    /**
     *  @inheritdoc
    */
    public function isApplicable(TransactionContext $context)
    {
        $eventDate = $context->getAccountingEvent()->getOccuredDate();
        $applyFrom = $this->getApplyDate();
        
        return ($eventDate < $applyFrom) ? false : true;
    }
    
    // --------------------------------------------------------
    # RuleChainInterface
    
    /**
     *  @inheritdoc
    */
    public function getProcessingMode()
    {
        return $this->processEntireChain;
    }
    
    /**
     *  @inheritdoc
    */
    public function getErrorMode()
    {
        return $this->stopOnFirstException;
    }
    
    /**
     *  @inheritdoc
    */
    public function registerRule(PostingRuleInterface $rule)
    {
        $this->rules->add($rule);
    }
    
    /**
     *  @inheritdoc
    */
    public function getApplyDate()
    {
        return $this->applyDate;
    }
    
}
/* End of Class */
