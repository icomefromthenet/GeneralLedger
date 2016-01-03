<?php 
namespace IComeFromTheNet\GeneralLedger\Step;

use DateTime;
use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;
use IComeFromTheNet\GeneralLedger\TransactionProcessInterface;

/**
 * Common Class for transaction processing steps
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
abstract class CommonStep implements TransactionProcessInterface
{
    /**
     * @var Doctrine\DBAL\Connection
     */ 
    protected $oDatabaseAdapter;
    
    /**
     * @var Psr\Log\LoggerInterface;
     */ 
    protected $oLogger;
    
    /**
     * @var array 
     */ 
    protected $aTableMap;
    
   
    public function getDatabaseAdapter()
    {
        return $this->oDatabaseAdapter;
    }
    
   
    public function getLogger()
    {
        return $this->oLogger;
    }
    
    /**
     * Return an array of interal tables names map to actual names
     *  
     * @return array(internal_name => actual_name)
     */ 
    public function getTableMap()
    {
        return $this->aTableMap;
    }
    
    
    
    public function __construct(LoggerInterface $oLogger, Connection $oDatabaseAdapter, array $aTableMap)
    {
        $this->aTableMap        = $aTableMap;
        $this->oDatabaseAdapter = $oDatabaseAdapter;
        $this->oLogger          = $oLogger; 
        
    }
    
   
}
/* End of Class */