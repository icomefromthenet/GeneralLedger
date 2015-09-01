<?php 
namespace IComeFromTheNet\Ledger\Voucher\Operations;

use DateTime;
use DBALGateway\Exception as DBALGatewayException;
use IComeFromTheNet\Ledger\Voucher\VoucherException;
use IComeFromTheNet\Ledger\Voucher\DB\VoucherGroup;
use IComeFromTheNet\Ledger\Voucher\DB\VoucherGroupGateway;

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
     * @param VoucherGroupGateway    $oGateway   The Database Table Gateway
     * @param DateTime          $oNow       The current datetime.
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
        $bSuccess        = false;
        
        if(false === empty($oVoucherGroup->getVoucherGroupId())) {
            throw new VoucherException('Unable to create new voucher group the Entity has a database id assigned already');
        }
    
        try {
        
            $oQuery = $oGateway->insertQuery()->start();
            
            foreach($oVoucherBuilder->demolish($oVoucherGroup) as $sColumn => $mValue) {
                
                if($sColumn !== 'voucher_group_id' && $sColumn !== 'date_created') {
                    
                    $oQuery->addColumn($sColumn,$mValue);
                    
                } elseif($sColumn === 'date_created') {
                  
                    $oQuery->addColumn('date_created',$this->oNow);
                    
                }
                
            }
            
            $bSuccess = $oQuery->end()->insert(); 
            
    
            if($bSuccess) {
                $oVoucherGroup->setVoucherGroupId($oGateway->lastInsertId());
            }
        
        }
        catch(DBALGatewayException $e) {
            throw new VoucherException($e->getMessage(),0,$e);
        }
        
        
        
        return $bSuccess;    
    }
    
}
/* End of Class */