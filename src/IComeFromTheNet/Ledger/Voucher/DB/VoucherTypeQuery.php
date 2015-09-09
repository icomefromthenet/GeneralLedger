<?php
namespace IComeFromTheNet\Ledger\Voucher\DB;

use DateTime;
use DBALGateway\Query\AbstractQuery;
use DBALGateway\Query\QueryInterface;

/**
  *  Vouch Type Query Builder
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class VoucherTypeQuery extends AbstractQuery implements QueryInterface
{
    
    /**
     * Find those voucher type that are currently enabled.
     * 
     * Those that have a valid date <= max and >=
     */ 
    public function filterCurrent(DateTime $oFrom)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        $oTo      = date_create_from_format('Y-m-d','3000-01-01');
        
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
  
        
        $paramTypeFrom = $oGateway->getMetaData()->getColumn('voucher_enabled_from')->getType();
        $paramTypeTo   = $oGateway->getMetaData()->getColumn('voucher_enabled_to')->getType();


        $this->andWhere($this->expr()->gte($sAlias.'voucher_enabled_from',$this->createNamedParameter($oFrom,$paramTypeFrom)))
             ->andWhere($this->expr()->lte($sAlias.'voucher_enabled_to',$this->createNamedParameter($oFrom,$paramTypeTo)));

        return $this;
    }
    
    
    
    /**
     * Filter the vouchers by the type database id
     * 
     * @return this
     * @param integer   $iVoucherTypeId The database id of this voucher type
     */ 
    public function filterByVoucherType($iVoucherTypeId)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
  
        $paramType = $oGateway->getMetaData()->getColumn('voucher_type_id')->getType();
        
        $this->andWhere($sAlias.'voucher_type_id = '.$this->createNamedParameter($iVoucherTypeId,$paramType));
        
        return $this;
    }
    
    
    
    
    /**
     * Filter a voucher type by name (use the slug version)
     * 
     * @param string $sSlugName the slug name for this voucher
     */ 
    public function filterByVoucherTypeName($sSlugName)
    {
       $oGateway = $this->getGateway();
       $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
    
        $paramType = $oGateway->getMetaData()->getColumn('voucher_name_slug')->getType();
        
        $this->andWhere($sAlias. 'voucher_name_slug = '.$this->createNamedParameter($sSlugName,$paramType));
             
        return $this;
    }
    
    
}
/* End of Class */
