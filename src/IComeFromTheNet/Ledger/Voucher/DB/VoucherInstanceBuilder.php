<?php
namespace IComeFromTheNet\Ledger\Voucher\DB;

use DBALGateway\Builder\AliasBuilder;

/**
 * Builds Voucher Instances
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class VoucherInstanceBuilder extends AliasBuilder
{
    
    
     /**
      *  Convert data array into entity
      *
      *  @return VoucherGroup
      *  @param array $data
      *  @access public
      */
    public function build($data)
    {
        
        $oEntity           = new VoucherInstance();
        $sAlias            = $this->getTableQueryAlias();
        
        $iVoucherInstanceId   = $this->getField($data,'voucher_instance_id',$sAlias);
        $iVoucherTypeId       = $this->getField($data,'voucher_type_id',$sAlias);
        $sVoucherCode         = $this->getField($data,'voucher_code',$sAlias);
        $oDateCreated         = $this->getField($data,'date_created',$sAlias); 
        
        $oEntity->setVoucherInstanceId($iVoucherInstanceId);
        $oEntity->setVoucherTypeId($iVoucherTypeId);
        $oEntity->setVoucherCode($sVoucherCode);
        $oEntity->setDateCreated($oDateCreated);
        
        return $oEntity;
        
    }
    
    /**
      *  Convert and entity into a data array that match database columns in table
      *
      *  @return array
      *  @access public
      *  @param VoucherGroup    $entity A voucher group entity
      */
    public function demolish($entity)
    {
        $aData = array(
            'voucher_instance_id'=> $entity->getVoucherInstanceId()
            ,'voucher_type_id'   => $entity->getVoucherTypeId()
            ,'voucher_code'      => $entity->getVoucherCode()
            ,'date_created'      => $entity->getDateCreated()
        );
        
        
        return $aData;
    }
    
}
/* End of class */