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
    
    protected function getVoucherTypeDetails()
    {
        $oGateway = $oGateway->getGatewayProxyCollection()->getGateway(VoucherContainer::DB_TABLE_VOUCHER_TYPE);
        
        return array(
            'sTableName' => $oGateway->getMetaData()->getName(),
            'sTableAlias'     => $oGateway->getTableQueryAlias()
        );
    }
    
    
    /**
     *  Filter a voucher group by its Primary Key
     * 
     * @param integer $id   The Voucher PK
     * @return VoucherGroupQuery
     */ 
    public function filterByGroup($id)
    {
        
        $this->where('voucher_group_id = :voucher_group_id')->setParameter('voucher_group_id', $id, $this->getGateway()->getMetaData()->getColumn('voucher_group_id')->getType());
        return $this;
        
    }
   
   
   /**
    * Remove voucher groups have been used by a voucher types
    * 
    * @return  VoucherGroupQuery
    */ 
    public function filterByGroupNotUsed()
    {
        $aTypeDetails      = $this->getVoucherTypeDetails();
        $sTableAlias       = $this->getGateway()->getTableQueryAlias();
        $sTypeTableAlias   = 'vtype';
        $sTypeTableName    = $aTypeDetails['sTableName'];
        
        $sJoinCondition    = $sTypeTableAlias.'.voucher_group_id = '.$sTableAlias.'.voucher_group_id';
        
        $this->leftJoin($sTableAlias, $sTypeTableName, $sTypeTableAlias, $sJoinCondition)
             ->andWhere($sTypeTableAlias.'.voucher_group_id IS NULL');         
                    
        return $this;
    }
   
   
    

}
/* End of Class */

