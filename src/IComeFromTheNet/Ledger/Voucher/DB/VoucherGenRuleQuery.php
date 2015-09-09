<?php
namespace IComeFromTheNet\Ledger\Voucher\DB;

use DBALGateway\Query\AbstractQuery;
use DateTime;

/**
 * Builds Voucher Generator Rules Queries
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class VoucherGenRuleQuery extends AbstractQuery
{

    /**
     *  Filter a voucherGenRule by its Primary Key
     * 
     * @param integer $id   The Voucher PK
     * @return VoucherGenRuleQuery
     */ 
    public function filterByRule($id)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('voucher_gen_rule_id')->getType();
        
        return $this->andWhere($sAlias."voucher_gen_rule_id = ".$this->createNamedParameter($id,$paramType));
        
    }
   
   
   /**
     *  Filter a voucherGenRule by its Primary Key
     * 
     * @param integer $id   The Voucher PK
     * @return VoucherGenRuleQuery
     */ 
    public function filterByRuleName($sRuleSlug)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }

        $paramTye = $oGateway->getMetaData()->getColumn('voucher_rule_slug')->getType();
        
        return $this->andWhere($sAlias."voucher_rule_slug = ".$this->createNamedParameter($sRuleSlug,$paramType));
    }
    
    
    public function filterByCreatedBefore(DateTime $oDate)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('date_created')->getType();
        
        
        return $this->andWhere($sAlias."date_created < ".$this->createNamedParameter($oDate,$paramType));
    }
    
    public function filterByCreatedAfter(DateTime $oDate)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('date_created')->getType();
        
        
        return $this->andWhere($sAlias."date_created > ".$this->createNamedParameter($oDate,$paramType));
    }
    
    
    public function filterBySequenceStrategy($sSequenceStrategy)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        $paramType = $oGateway->getMetaData()->getColumn('voucher_sequence_strategy')->getType();
        
        
        return $this->andWhere($sAlias."voucher_sequence_strategy = ".$this->createNamedParameter($id,$paramType));
    }

}
/* End of Class */

