<?php 
namespace IComeFromTheNet\Ledger\Voucher\Operations;

use DateTime;
use DBALGateway\Exception as DBALGatewayException;
use IComeFromTheNet\Ledger\Voucher\VoucherException;
use IComeFromTheNet\Ledger\Voucher\DB\VoucherType;
use IComeFromTheNet\Ledger\Voucher\DB\VoucherTypeGateway;

/**
 * Operation will expire an existing voucher type
 * 
 * Set the enabled to date on this entity to the given or default to now
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class TypeExpire 
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
        
        if(true === empty($oVoucherGroup->getVoucherTypeId())) {
            throw new VoucherException('Unable to update voucher type the Entity requires a database id assigned already');
        }
    
        try {
        
            $oQuery = $oGateway->updateQuery()->start();
            
            foreach($oVoucherBuilder->demolish($oVoucherType) as $sColumn => $mValue) {
                
                if ($sColumn === 'voucher_enabled_to') {
                    
                    if($mValue !== null) {
                        $oQuery->addColumn($sColumn,$mValue);
                    } else {
                        $oQuery->addColumn($sColumn,$this->oNow);
                    }
                    
                }
                    
            }
            
            $bSuccess = $oQuery->where()
                            ->filterByVoucherType($oVoucherType->getVoucherTypeId())
                        ->end()
                        ->update(); 
        
        }
        catch(DBALGatewayException $e) {
            throw new VoucherException($e->getMessage(),0,$e);
        }
        
        
        return $bSuccess;    
    }
    
}
/* End of Class */