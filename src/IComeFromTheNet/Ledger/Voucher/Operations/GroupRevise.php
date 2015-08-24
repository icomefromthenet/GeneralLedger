<?php 
namespace IComeFromTheNet\Ledger\Voucher\Operations;

use DateTime;
use DBALGateway\Exception as DBALGatewayException;
use IComeFromTheNet\Ledger\Voucher\VoucherException;
use IComeFromTheNet\Ledger\Voucher\DB\VoucherGroup;
use IComeFromTheNet\Ledger\Voucher\DB\VoucherGateway;

/**
 * Operation will save a new voucher group, not be used to update existing
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class GroupCreate 
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
     * @param VoucherGateway    $oGateway   The Database Table Gateway
     * @param DateTime          $oNow       The current datetime.
     */ 
    public function __construct(VoucherGateway $oGateway, DateTime $oNow)
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
       
        if(true === empty($oVoucherGroup->getVoucherGroupID())) {
            throw new VoucherException('Unable to save voucher group the Entity has no database id assigned');
        }
    
        try {
        
            $oQuery = $oGateway->updateQuery()->start();
            
            foreach($oVoucherBuilder->demolish($oVoucherGroup) as $sColumn => $mValue) {
                
                if($sColumn !== 'voucher_group_id' && $sColumn !== 'date_created') {
                    
                    $oQuery->addColumn($sColumn,$mValue);
                    
                } 
                
            }
            
            $bSuccess = $oQuery->where()
                                    ->filterByGroup($oVoucherGroup->getVoucherGroupID())
                                ->end()
                            ->update(); 
    
    
            if($success) {
                $oVoucherGroup->setVoucherGroupID($gateway->lastInsertId());
            }
        
        }
        catch(DBALGatewayException $e) {
            throw new VoucherException($e->getMessage(),0,$e);
        }
        
        
        return $success;    
    }
    
}
/* End of Class */