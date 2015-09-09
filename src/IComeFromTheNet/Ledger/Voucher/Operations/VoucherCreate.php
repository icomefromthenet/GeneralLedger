<?php 
namespace IComeFromTheNet\Ledger\Voucher\Operations;

use DateTime;
use DBALGateway\Exception as DBALGatewayException;
use IComeFromTheNet\Ledger\Voucher\VoucherException;
use IComeFromTheNet\Ledger\Voucher\DB\VoucherInstance;
use IComeFromTheNet\Ledger\Voucher\DB\VoucherInstanceGateway;

/**
 * Operation will save a new voucher instance, not be used to update existing
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class VoucherCreate 
{
    
    /**
     * @var VoucherInstanceGateway
     */ 
    protected $oGateway;
    
    /**
     * @var DateTime
     */ 
    protected $oNow;
    
    
    /**
     * Class Constructor
     * 
     * @access public
     * @return void
     * @param VoucherInstanceGateway    $oGateway   The Database Table Gateway
     * @param DateTime                  $oNow       The current datetime.
     */ 
    public function __construct(VoucherInstanceGateway $oGateway, DateTime $oNow)
    {
        $this->oGateway = $oGateway;
        $this->oNow     = $oNow;
    }
    
    
    
    /**
     * Create a Voucher Instance
     * 
     * @param VoucherInstance  $oVoucherGroup  The Voucher Instance to save
     * @throws VoucherException if the database query fails or entity has id assigned.
     * @returns boolean true if the insert operation was successful
     */ 
    public function execute(VoucherInstance $oVoucherInstance)
    {
        $oGateway        = $this->oGateway;
        $oBuilder = $oGateway->getEntityBuilder();
       
        if(false === empty($oVoucherInstance->getVoucherInstanceId())) {
            throw new VoucherException('Unable to create new voucher instance the Entity has a database id assigned already');
        }
    
        try {
        
            $oQuery = $oGateway->insertQuery()->start();
            
            foreach($oBuilder->demolish($oVoucherInstance) as $sColumn => $mValue) {
                
                if($sColumn !== 'voucher_instance_id' && $sColumn !== 'date_created') {
                    
                    $oQuery->addColumn($sColumn,$mValue);
                    
                } elseif($sColumn === 'date_created') {
                  
                    $oQuery->addColumn('date_created',$this->oNow);
                    
                }
                
            }
            
            $bSuccess = $oQuery->end()->insert(); 
    
            
    
            if($success) {
                $oVoucherInstance->setVoucherInstanceId($gateway->lastInsertId());
            }
        
        }
        catch(DBALGatewayException $e) {
            throw new VoucherException($e->getMessage(),0,$e);
        }
        
        
        return $success;    
    }
    
}
/* End of Class */