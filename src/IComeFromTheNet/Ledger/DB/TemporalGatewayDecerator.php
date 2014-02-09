<?php 
namespace IComeFromTheNet\Ledger\DB;

use PDO;
use DateInterval;
use DateTime;
use Exception;
use IComeFromTheNet\Ledger\DB\TemporalGatewayDecoratorInterface;
use IComeFromTheNet\Ledger\DB\TemporalGatewayInterface;
use IComeFromTheNet\Ledger\Exception\LedgerException;

class TemporalGatewayDecerator implements TemporalGatewayDeceratorInterface
{
   
    const STATUS_TAKEN         = 0;
    const STATUS_EMPTY         = 1;
    const STATUS_CLOSE_CURRENT = 2; 
   
   
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
        $f = clone $from;
        $t = clone $to;
        
        if($f > $t) {
            throw new LedgerException('The opening from date occurs after the closing to date');
        }
        
        $f->add($this->minSlotInterval);
        
        # validate slot length
        if($f > $t) {
            throw new LedgerException('The length of the slot is below the minimum allowed');
        }
        
        return true;
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
        
        $this->validateSlot($from,$to);
        
        $query          = $this->getTableGateway()->newQueryBuilder();
        $dbal           = $this->getTableGateway()->getAdapater();
        $temporalMap    = $this->getTableGateway()->getTemporalColumns();
        
        $tableName      = $this->getTableGateway()->getMetaData()->getName();
        
        $slugColumn     = $temporalMap->getSlugColumn();
        $fromColumn     = $temporalMap->getFromColumn();
        $toColumn       = $temporalMap->getToColumn();
        
        $toColumnName   = $toColumn->getName();
        $fromColumnName = $fromColumn->getName();
        $slugColumnName = $slugColumn->getName();
        
        $toColumnType   = $toColumn->getType();
        $fromColumnType = $fromColumn->getType();
        $slugColumnType = $slugColumn->getType();
        
        $available      = self::STATUS_TAKEN;
        
        try {
        
            $statement->select($slugColumn . ' AS slugColumn')
                  ->select($fromColumn . ' AS fromColumn')
                  ->select($toColumn   . ' AS toColumn')
                  ->from($tableName)
                  ->where($query->expr()->eq($slugColumnName,' :slug_id'))
                  ->andWhere($query->expr()->andX(
                    $query->expr()->gte($fromColumnName,':fromDate'),
                    $query->expr()->lte($fromColumnName,':toDate')))
                  ->setParameter(':slug_id', $entitySlug,$slugColumnType)
                  ->setParameter(':fromDate',$from,$fromColumnType)
                  ->setParameter('toDate'.$to,$toColumnType)
                  ->setMaxResults(1)
                  ->execute();
            
            $selectedRow = $statement->fetch(PDO::FETCH_ASSOC);
            
            if($selectedRow === false) {
                $available = self::STATUS_EMPTY;
            }
            else {
                
                # check for current slot is set with max date ie open ended stop time.
                $selectedToDate = $toColumnType->convertToPHPValue($selectedRow['toColumn'], $dbal->getDatabasePlatform());
                $fromToDate     = $fromColumnType->convertToPHPValue($selectedRow['fromColumn'], $dbal->getDatabasePlatform());
                
                if($selectedToDate->format('d/m/y') == $this->maxDate->format('d/m/y')) {
                    
                    # check if the current row selected can be closed when consider
                    # the minimum slot interval
                    if($fromToDate->add($this->minSlotInterval) < $from) {
                      $available = self::STATUS_CLOSE_CURRENT;    
                    }
                    
                }
            }
        }
        catch (Exception $e) {
            throw new LedgerException($e->getMessage());
        }
        
        return $available;
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
    
    public function findManySlotsUntil($entitySlug, DateTime $from, DateTime $until)
    {
        
        
    }
    
    public function findAllCurrentSlots(DateTime $processingDate)
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
