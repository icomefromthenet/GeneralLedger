<?php
namespace IComeFromTheNet\Ledger\Voucher\DB;

use DBALGateway\Query\AbstractQuery;
use DateTime;
use IComeFromTheNet\Voucher\VoucherContainer;

/**
 * Builds Voucher Group Queries 
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class VoucherGroupQuery extends AbstractQuery
{
    
    
    /**
     *  Filter a voucher group by its Primary Key
     * 
     * @param integer $id   The Voucher PK
     * @return VoucherGroupQuery
     */ 
    public function filterByGroup($id)
    {
        $oGateway = $this->getGateway();
        $oAlias   = $oGateway->getTableQueryAlias();
        $paramType = $oGateway->getMetaData()->getColumn('voucher_group_id')->getType();
        
        return $this->andWhere("$oAlias.voucher_group_id = ".$this->createNamedParameter($id,$paramType));
        
    }
   

}
/* End of Class */

