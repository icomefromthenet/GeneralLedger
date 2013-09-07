<?php
namespace IComeFromTheNet\Ledger\Processing;

use DateTime;
use IComeFromTheNet\Ledger\Exception\LedgerException;
use IComeFromTheNet\Ledger\Processing\RuleChainInterface;
use IComeFromTheNet\Ledger\Processing\PostingRuleInterface;
use IComeFromTheNet\Ledger\Processing\NamedChainInterface;
use IComeFromTheNet\Ledger\Processing\TransactionContext;
use IComeFromTheNet\Ledger\Processing\ErrorCollection;
use Doctrine\Common\Collections\Collection as CollectionInterface;


/**
  *  Exists to store RuleChains that can overwrite each other given a date.
  *
  *  When accounting events are reversed they must be processed by
  *  an identical RuleChain but chains need to adapt for future changes.
  *  This class allows a RuleChain to change overtime be considering
  *  each RuleChain to belong to a time period (Temporal Property)
  *
  *  
  *
  *  The occured date will be used to map to a rule chain.
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class NamedChain implements NamedChainInterface,PostingRuleInterface
{
    /*
     * @var string the name of this chain
     */
    protected $name;
    
    /*
     * @var Doctrine\Common\Collections\Collection
     */
    protected $chainCollection;
    
    
    public function __construct(CollectionInterface $chainCollection,$name)
    {
        $this->name            = $name;
        $this->chainCollection = $chainCollection;
        
        if(empty($this->name)) {
            throw new LedgerException('Named Chain must not have an empty name param');
        }
    }
    
    
    // --------------------------------------------------------
    # PostingRuleInterface
    
    /**
     *  @inheritdoc
    */
    public function execute(TransactionContext $context, ErrorCollection $errors)
    {
        if(count($this->chainCollection) === 0) {
            throw new LedgerException('There are 0 RuleChains, can not process accountingEvent');
        }
        
        # find the last applicable rule

        
        foreach($this->chainCollection as $rule) {
           
            
        }
    }
    
    /**
     *  @inheritdoc
    */
    public function isApplicable(TransactionContext $context)
    {
        # temporal collection will determine applicability of this chain
        return true;
    }
   
    
    
    // --------------------------------------------------------
    # Named Chain Interface
    
    /**
     *  @inheritdoc
    */
    public function registerChain(RuleChainInterface $chain)
    {
        $this->chainCollection->add($chain);
    }
    
    /**
     *  @inheritdoc
    */
    public function getName()
    {
        return $this->name;
    }
    
}
/* End of Class */

