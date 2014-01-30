<?php 
namespace IComeFromTheNet\Ledger\Entity;

use DateInterval;
use DateTime;
use IComeFromTheNet\Ledger\Entity\TemporalGatewayDecoratorInterface;
use IComeFromTheNet\Ledger\Entity\TemporalGatewayInterface;

class TemporalGatewayDecerator implements TemporalGatewayDeceratorInterface
{
    /**
     * @var  IComeFromTheNet\Ledger\Entity\TemporalGatewayInterface
     */
    protected $gateway;

    /**
    * @var DateTime the processing date of the ledger instance
    *
    */
    protected $processingDate;

    /**
    *  @var DateTime the max date used to represent and open ended slot
    */
    protected $maxDate;

   /**
   * @var DateInterval the min length of time a slot opens
   */
    protected $minSlotInterval;


    /**
     *  Validate if slot is valid
     * 
     * @access protected
     * @param DateTime $from
     * @param DateTime $to
     * @return boolean true if valid
     */ 
    protected function validateSlot(DateTime $from, DateTime $to)
    {
        # from  
        
        
        # validate slot length
        
    }
    
    

    /**
     *  Class Constructor
     * 
     *  @access public
     *  @return void
     *  @param TemporalGatewayInterface $tableGateway the gateway to decorate
     */ 
    public function __construct(TemporalGatewayInterface $tableGateway, DateTime $processingDate, DateTime $maxDate, DateInterval $minSlotInterval)
    {
        $this->gateway         = $tableGateway;
        $this->processingDate  = $processingDate;
        $this->maxDate         = $maxDate;
        $this->minSlotInterval = $minSlotInterval;
    }
    
    
    
  
    public function isSlotAvailable($entitySlug, DateTime $from, DateTime $to)
    {
        $query        = $this->getTableGateway()->newQueryBuilder();
        $dbal         = $this->getTableGateway()->getAdapater();
        $temporalMap  = $this->getTableGateway()->getTemporalColumns();
        
        $tableName    = $this->getTableGateway()->getMetaData()->getName();
        
        $slugColumn = $temporalMap->getSlugColumn();
        $fromColumn = $temporalMap->getFromColumn();
        $toColumn   = $temporalMap->getToColumn();
        
        $toColumnName   = $toColumn->getName();
        $fromColumnName = $fromColumn->getName();
        $slugColumnName = $slugColumn->getName();
        
        $toColumnType   = $toColumn->getType();
        $fromColumnType = $fromColumn->getType();
        $slugColumnType = $slugColumn->getType();
        
        
        $dateRangeQuery = $query->expr()->andX
                $query->expr()->gte($fromColumnName,':fromDate'),
                $query->expr()->gte($fromColumnName,':toDate'),
                
        )->setParameter(':fromDate',$from,$fromColumnType)
         ->setParameter('toDate'.$to,$toColumnType);
        
        $query->select('1')
              ->from($tableName)
              ->where($query->expr()->eq($slugColumnName,' :slug_id')
              ->andWhere($dateRangeQuery)
              ->setParameter(':slug_id', $entitySlug,$slugColumnType)
              ->setMaxResults(1);
              
        
        $statement = $query->execute($query->getSql());
        
        return (boolean) $statement->fetchColumn(1);
             
    }

   
    public function findCurrentSlot($entitySlug, DateTime $processingDate)
    {
        
    }
    

    public function closeSlot($entitySlug, DateTime $processingDate, DateTime $from, DateTime $to = null )
    {
                                  
    }
    
    public function findOneSlot($entitySlug,DateTime $from)
    {
        
    }
    
    public function findManySlotsUntil($entitySlug, DateTime $from, DateTime $until);
    {
        
        
    }
    
    public function findAllCurrentSlots(DateTime $processingDate);
    {
        
        
    }
   
   
   
    
    //--------------------------------------------------------------------------
    # Properties
    
    /**
     * Fetch the assigned gateway
     * 
     * @return TemporalGatewayInterface
     */ 
    public function getTableGateway()
    {
        return $this->gateway;
    }
  
    /**
     * Fetch the assigned ledger processing date
     * 
     * @return DateTime the ledger processing date
     * @access public 
     */ 
    public function getProcessingDate()
    {
        return $this->processingDate;
    }
    
    /**
     * Fetch the max date used to represent
     * an open ended slot.
     * 
     * @access public
     * @return DateTime the max open ended date
     * 
     */ 
    public function getMaxDate()
    {
        return $this->maxDate;
    }

    /**
     * Fetch the min length of slot 
     * 
     * @return DateInterval the min length of slot
     * @access public
     */
    public function getMinSlotInterval()
    {
        return $this->minSlotInterval;
    }

}
/* End of File */
