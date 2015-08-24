<?php 
namespace IComeFromTheNet\Ledger\Voucher\Operations;

use DateTime;
use Psr\Log\LoggerInterface;
use DBALGateway\Table\AbstractTable;
use IComeFromTheNet\Ledger\Voucher\VoucherException;

/**
 * Decorate a voucher operation and used to log the success or failure status
 * to app logger.
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class LoggerDecorator 
{
    /**
     * @var DateTime
     */ 
    protected $oNow;
    
    /**
     * @var Psr\Log\LoggerInterface
     */ 
    protected $oLogger;
    
    /**
     * @var an operations class
     */ 
    protected $oOperation;
    
    /**
     * Class Constructor
     * 
     * @access public
     * @return void
     * @param mixed             $oOperation  The decorated class
     * @param DateTime          $oNow       The current datetime.
     * @param LoggerInterface   $oLogger    The App Logger 
     */ 
    public function __construct($oOperation, DateTime $oNow, LoggerInterface $oLogger)
    {
        $this->oOperation = $oOperation;
        $this->oNow       = $oNow;
        $this->oLogger    = $oLogger;
    }
    
    
    /**
     * Execute the decorated operation and log
     * the success status to the app logger
     * 
     * @access public
     * @return boolean the result of the operation
     * @param mixed     $oMixed     The Entity to do operation on
     */ 
    public function execute($oMixed)
    {
       $oLogger         = $this->oLogger;
       $oOperation      = $this->oOperation;
       $sOperationClass = get_class($this->oOperation);
       
       try {
            $bResult = $oOperation->execute($oMixed);
            
            if(true === $bResult) {
                $oLogger->info('Voucher Operation successful :: {sClass}', array('sClass'=> $sOperationClass));
            } else {
                $oLogger->error('Voucher Operation failed :: {sClass} for unknown reason',array('sClass'=> $sOperationClass));
            }
       
       } catch(VoucherException $e) {
           $oLogger->error('Voucher Operation failed :: {sClass} with message {sMessage}',array('sClass'=> $sOperationClass,'sMessage'=>$e->getMessage()));   
           throw $e;
       }
       
       return $bResult;
       
    }
    
}
/* End of Class */