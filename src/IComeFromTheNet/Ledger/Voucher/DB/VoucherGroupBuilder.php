<?php
namespace IComeFromTheNet\Ledger\Voucher\DB;

use DBALGateway\Builder\AliasBuilder;

/**
 * Builds Voucher Groups
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class VoucherGroupBuilder extends AliasBuilder
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
        
        $oEntity           = new VoucherGroup();
        $sAlias            = $this->getTableQueryAlias();
        
        $iVoucherGroupId   = $this->getField($data,'voucher_group_id',$sAlias);
        $sVoucherGroupName = $this->getField($data,'voucher_group_name',$sAlias);
        $sVoucheGroupSlug  = $this->getField($data,'voucher_group_slug',$sAlias);
        $bIsDisabled       = $this->getField($data,'is_disabled',$sAlias);    
        $iSortOrder        = $this->getField($data,'sort_order',$sAlias);
        $oDateCreated      = $this->getField($data,'date_created',$sAlias);
        
        
        $oEntity->setVoucherGroupID($iVoucherGroupId);
        $oEntity->setVoucherGroupName($sVoucherGroupName);
        $oEntity->setSlugName($sVoucheGroupSlug);
        $oEntity->setDisabledStatus($bIsDisabled);
        $oEntity->setSortOrder($iSortOrder);
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
            'voucher_group_id'   => $entity->getVoucherGroupID()            
            ,'voucher_group_name' => $entity->getVoucherGroupName()
            ,'voucher_group_slug' => $entity->getSlugName()
            ,'is_disabled'        => $entity->getDisabledStatus()
            ,'sort_order'         => $entity->getSortOrder()
            ,'date_created'       => $entity->getDateCreated()
        );
        
        
        return $aData;
    }
    
}
/* End of class */