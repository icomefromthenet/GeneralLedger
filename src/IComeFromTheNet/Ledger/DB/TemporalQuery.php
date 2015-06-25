<?php
namespace IComeFromTheNet\Ledger\DB;

use IComeFromTheNet\Ledger\Exception\LedgerException;
use DBALGateway\Table\TableInterface;
use DBALGateway\Query\AbstractQuery;
use DateTime;

/**
 * Query for temporal tables
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class TemporalQuery extends AbstractQuery
{

    protected $maxDate;
    
    
    /**
     * Load the temporal map from the assigned gateway
     * 
     * @access public
     * @return TemporalMap
     * 
     */ 
    protected function getTemportalMap()
    {
        return $this->getGateway()->getTemporalColumns();
    }
    
    
    /**
      *  Class Constructor
      *
      *  @access public
      *  @param Connection $connection
      *  @param TableInterface $table
      *  @param DateTime $maxDate 
      */
    public function __construct(Connection $connection,TableInterface $table,DateTime $maxDate)
    {
        
        $this->maxDate = $maxDate;
        
        parent::__construct($connection,$table);
    }


    /**
     * Filter by the entity identity column or commonly the slug column
     * 
     * An entity can have many instance but share and identity value.
     * 
     * @access public
     * @return TemporalQuery
     */ 
    public function filterByIndentity($slugName)
    {
        if(empty($slugName)) {
            throw new LedgerException('Slug name must not be an empty value'); 
        }
        
        $idColumn = $this->getTemportalMap()->getSlugColumn();
        
        
        $this->andWhere($this->expr()->eq($idColumn->getName(),' :slug_id'));
        $this->setParam('slug_id',$slugName,$idColumn->getType());
        
        return $this;
        
        
    }

    /**
     * Filter to those that occur on and after posting date x
     * 
     * @access public
     * @return TemporalQuery
     * @param DateTime $postingDate
     * 
     */ 
    public function filterOnAndAfterPostingDate(DateTime $postingDate)
    {
        
        $postingDateColumn = $this->getTemportalMap()->getPostingDateColumn();
        
        
        $this->andWhere($this->expr()->gte($postingDateColumn->getName(),':on_after_posting_date'));
        $this->setParameter('on_after_posting_date', $postingDate, $postingDateColumn->getType());

    
        
        return $this;
    }
    
    /**
     * Filter to those that occur on or before the given posting date x
     * 
     * @access public
     * @return TemporalQuery
     * @param DateTime $postingDate
     */ 
    public function filterOnAndBeforePostingDate(DateTime $postingDate)
    {
        $postingDateColumn = $this->getTemportalMap()->getPostingDateColumn();
        
        $this->andWhere($this->expr()->lte($postingDateColumn->getName(),':on_before_posting_date'));
        $this->setParameter('on_before_posting_date', $postingDate, $postingDateColumn->getType());
        
        
        return $this;
    }

    /**
     * Filter to those that have posting date of x
     * 
     * @access public
     * @param DateTime $postingDate 
     * @return TemporalQuery
     */ 
    public function filterAtPostingDate(DateTime $postingDate)
    {
        $postingDateColumn = $this->getTemportalMap()->getPostingDateColumn();
        
        $this->andWhere($this->expr()->eq($postingDateColumn->getName(),':on_posting_date'));
        $this->setParameter('on_posting_date', $postingDate, $postingDateColumn->getType());

        
        return $this;
    }

    /**
     * Filter those that open affinity date occurs on or after x
     * 
     *  @access public
     *  @return TemporalQuery
     *  @param DateTime $openingDate
     */ 
    public function filterOnAfterOpeningDate(DateTime $openingDate)
    {
        $openingDateColumn = $this->getTemportalMap()->getFromColumn();
        
        $this->andWhere($this->expr()->gte($openingDateColumn->getName(),':on_after_opening_date'));
        $this->setParameter('on_after_opening_date',$openingDate,$openingDateColumn->getType());
        
        return $this;
    }
    
    /**
     * Filter those that open affinity date occurs on or before x
     * 
     * @access public
     * @return TemporalQuery
     * @param DateTime $openingDate
     */ 
    public function filterOnBeforeOpeningDate(DateTime $openingDate)
    {
        $openingDateColumn = $this->getTemportalMap()->getFromColumn();
    
        $this->andWhere($this->expr()->lte($openingDateColumn->getName(),':on_before_opening_date'));
        $this->setParameter('on_before_opening_date',$openingDate,$openingDateColumn->getType());    
        
        return $this;
    }
    
    /**
     * Filter those that have an oening affinity date occurs on date x
     * 
     * @access public
     * @return TemporalQuery
     * @param DateTime $openingDate
     */ 
    public function filterAtOpeningDate(DateTime $openingDate)
    {
        $openingDateColumn = $this->getTemportalMap()->getFromColumn();
        
        $this->andWhere($this->expr()->eq($openingDateColumn->getName(),':on_openeing_date'));
        $this->setParameter('on_openeing_date',$openingDate,$openingDateColumn->getType());
        
        return $this;
    }
    
    
    /**
     * Filter on closing affinity date on or before date x
     * 
     * @access public
     * @return TemporalQuery
     * @param DateTime $closeDate
     */ 
    public function filterOnBeforeClonsingDate(DateTime $closeDate)
    {
        $closingDateColumn = $this->getTemportalMap()->getToColumn();
    
        $this->andWhere($this->expr()->lte($closingDateColumn->getName(),':on_before_closing_date'));
        $this->setParameter('on_before_closing_date',$closeDate,$closingDateColumn->getType());
    
        return $this;
    }
    
    /**
     * Filter on closing affinity date on or after date x
     * 
     * @access public
     * @return TemporalQuery
     * @param DateTime $closeDate
     */ 
    public function filterOnAfterClosingDate(DateTime $closeDate)
    {
        $closingDateColumn = $this->getTemportalMap()->getToColumn();
        
        $this->andWhere($this->expr()->gte($closingDateColumn->getName(),':on_after_closing_date'));
        $this->setParameter('on_after_closing_date',$closeDate,$closingDateColumn->getType());

        
        return $this;    
    }
    
    /**
     * Filter on closing affinity date on date x
     * 
     * @access public
     * @return TemporalQuery
     * @param DateTime $closeDate
     */ 
    public function filterAtClosingDate(DateTime $closeDate)
    {
        $closingDateColumn = $this->getTemportalMap()->getToColumn();

        $this->andWhere($this->expr()->eq($closingDateColumn->getName(),':on_closing_date'));
        $this->setParameter('on_closing_date',$closeDate,$closingDateColumn->getType());
        
        return $this;
    }
    
    
    

    /**
     * Filter to those that have an open ended affinity period.
     * that is to say a closing date set to maxDate.
     * 
     * @access public
     * @return TemporalQuery
     */ 
    public function filterByOpenEnded()
    {
        $closingDateColumn = $this->getTemportalMap()->getToColumn();

        $this->filterAtClosingDate($this->maxDate);
            
        return $this;        
    }

    
    /**
     * Filter to slots that have an open-ended date (max date)
     * or 
     * 
     */ 
    public function filterByCurrentForIdentity(DateTime $processingDate,$identity)
    {
        $this->filterByIndentity($identity);
        
        
        
        return $this;
    }


}
/* End of File */