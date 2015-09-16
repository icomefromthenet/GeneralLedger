<?php 
namespace IComeFromTheNet\Ledger\Voucher\Operations;

use DateTime;
use DBALGateway\Exception as DBALGatewayException;
use IComeFromTheNet\Ledger\Voucher\VoucherException;
use IComeFromTheNet\Ledger\Voucher\DB\VoucherType;
use IComeFromTheNet\Ledger\Voucher\DB\VoucherTypeGateway;

/**
 * Operation will save a new voucher type, not be used to update existing
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class TypeCreate 
{
    
    /**
     * @var VoucherGateway
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
     * @param VoucherTypeGateway    $oGateway   The Database Table Gateway
     * @param DateTime              $oNow       The current datetime.
     */ 
    public function __construct(VoucherTypeGateway $oGateway, DateTime $oNow)
    {
        $this->oGateway = $oGateway;
        $this->oNow     = $oNow;
    }
    
    
    
    /**
     * Create a Voucher Type
     * 
     * @param VoucherType  $oVoucherType  The Voucher Group Entity
     * @throws VoucherException if the database query fails or entity has id assigned.
     * @returns boolean true if the insert operation was successful
     */ 
    public function execute(VoucherType $oVoucherType)
    {
        $oGateway        = $this->oGateway;
        $oVoucherBuilder = $oGateway->getEntityBuilder();
        $bSuccess        = false;
        
        if(false === empty($oVoucherType->getVoucherTypeId())) {
            throw new VoucherException('Unable to create new voucher type the Entity has a database id assigned already');
        }
    
        try {
        
            $oQuery = $oGateway->insertQuery()->start();
            $oEnabledToDate = date_create_from_format('Y-m-d','3000-01-01');
            
            foreach($oVoucherBuilder->demolish($oVoucherType) as $sColumn => $mValue) {
                
                if($sColumn !== 'voucher_type_id' && $sColumn !== 'voucher_enabled_to') {
                    
                    $oQuery->addColumn($sColumn,$mValue);
                    
                } elseif($sColumn === 'voucher_enabled_to') {
                    // making the new copy the currrent              
                    $oQuery->addColumn('voucher_enabled_to',$oEnabledToDate);
                }
                
            }
            
            $bSuccess = $oQuery->end()->insert(); 
            
    
            if($bSuccess) {
                $oVoucherType->setVoucherTypeId($oGateway->lastInsertId());
                $oVoucherType->setEnabledTo($oEnabledToDate);
            }
        
        }
        catch(DBALGatewayException $e) {
            throw new VoucherException($e->getMessage(),0,$e);
        }
        
        
        
        return $bSuccess;    
    }
    
}
/* End of Class */