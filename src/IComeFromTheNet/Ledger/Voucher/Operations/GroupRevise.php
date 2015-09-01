<?php 
namespace IComeFromTheNet\Ledger\Voucher\Operations;

use DateTime;
use DBALGateway\Exception as DBALGatewayException;
use IComeFromTheNet\Ledger\Voucher\VoucherException;
use IComeFromTheNet\Ledger\Voucher\DB\VoucherGroup;
use IComeFromTheNet\Ledger\Voucher\DB\VoucherGroupGateway;

/**
 * Operation will save an existing voucher group
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class GroupRevise 
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
     * @param VoucherGroupGateway    $oGateway   The Database Table Gateway
     * @param DateTime               $oNow       The current datetime.
     */ 
    public function __construct(VoucherGroupGateway $oGateway, DateTime $oNow)
    {
        $this->oGateway = $oGateway;
        $this->oNow     = $oNow;
    }
    
    
    
    /**
     * Create a Voucher Group
     * 
     * @param VoucherGroup  $oVoucherGroup  The Voucher Group Entity
     * @throws VoucherException if the database query fails or entity has id assigned.
     * @returns boolean true if the insert operation was successful
     */ 
    public function execute(VoucherGroup $oVoucherGroup)
    {
        $oGateway        = $this->oGateway;
        $oVoucherBuilder = $oGateway->getEntityBuilder();
       
        if(true === empty($oVoucherGroup->getVoucherGroupId())) {
            throw new VoucherException('Unable to save voucher group the Entity has no database id assigned');
        }
    
        try {
        
             $bSuccess = $oGateway->deleteQuery()
                    ->start()
                        ->filterByGroup($oVoucherGroup->getVoucherGroupId())
                    ->end()
                ->delete(); 
    
            if($bSuccess) {
                $oVoucherGroup->setVoucherGroupId(null);
            }
        
        }
        catch(DBALGatewayException $e) {
            throw new VoucherException($e->getMessage(),0,$e);
        }
        
        return $success;    
    }
    
}
/* End of Class */