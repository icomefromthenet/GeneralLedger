<?php 
namespace IComeFromTheNet\Ledger\Voucher\Operations;

use DateTime;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Query\QueryBuilder;
use DBALGateway\Table\AbstractTable;
use IComeFromTheNet\Ledger\Voucher\VoucherException;

/**
 * Decorate a voucher operation and used to log the success or failure status
 * to app logger.
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class LoggerDecerator 
{
    /**
     * @var DateTime
     */ 
    protected $oNow;
    
    /**
     * @var an operations class
     */ 
    protected $oOperation;
    
    /**
     * @var Doctrine\DBAL\Driver\Connection
     */ 
    protected $oConnection;
    
    /**
     * @var Doctrine\DBAL\Schema\Column
     */ 
    protected $oFromColumn;
    
    /**
     * @var Doctrine\DBAL\Schema\Column
     */ 
    protected $oToColumn;
    
    /**
     * @var array[ Doctrine\DBAL\Schema\Column] 
     */ 
    protected $oNaturalKeyColumns;
    
    /**
     * @var string the table name
     */ 
    protected $sTableName;
    
    /**
     * Class Constructor
     * 
     * @access public
     * @return void
     * @param mixed             $oOperation  The decorated class
     * @param DateTime          $oNow       The current datetime.
     * @param LoggerInterface   $oLogger    The App Logger 
     */ 
    public function __construct($oOperation, DateTime $oNow, Connection $oConnection, Column $oFromColumn, Column $oToColumn, array $oNaturalKeyColumns, $sTableName)
    {
        $this->oOperation         = $oOperation;
        $this->oNow               = $oNow;
        $this->oConnection        = $oConnection;
        $this->oFromColumn        = $oFromColumn;
        $this->oToColumn          = $oToColumn;
        $this->oNaturalKeyColumns = $oNaturalKeyColumns;
        $this->sTableName         = $sTableName;
        
    }
    
    
    /**
     * Check for Sequence Duplicates.
     * 
     * Episodes of the same entity that overlap in time.
     * 
     * @access public
     * @return boolean the result of the operation
     * @param mixed     $oMixed     The Entity to do operation on
     */ 
    public function execute($oMixed)
    {
        $oOperation      = $this->oOperation;
        $oConnection     = $this->oConnection;
        
        # execute operation, only care if its successful
        $bResult = $oOperation->execute($oMixed);
        $sTableName = $this->sTableName;
        if(true === $bResult) {
           
            try {
            
                $oInnerQuery = new QueryBuilder($oConnection);
                $oInnerQuery->select('count(*)')
                            ->from($sTableName,'s2')
                            ->andWhere('s1.'.$this->oFromColum->getName().' < s2.'.$this->oToColumn->getName().' ')
                            ->andWhere('s2.'.$this->oFromColum->getName().' < s1.'.$this->oToColumn->getName().' ');
                
                # process the key columns            
                foreach($this->oNaturalKeyColumns as $oColumn) {
                    $oInnerQuery->andWhere('s1.'.$oColumn->getName().' = s2.'.$oColumn->getName().' ');
                }
                
                // verify the consistence        
                $sSql = "SELECT count(*) FROM '.$sTableName.' AS s1
                    WHERE 1 < (
                        '.$oInnerQuery->getSql().'        
                ); ";
                                
               
               $iCount = (int) $oConnection->fetchColumn($sSql,array(),0);
               
               if($iCount > 0) {
                   throw new VoucherException('This entity has a sequence duplicate unable to finish operation');
               }
                
            } catch(DBALException $e) {
               throw new VoucherException($e->getMessage(),0,$e);
           }
       
        }
       
       return $bResult;
       
    }
    
}
/* End of Class */