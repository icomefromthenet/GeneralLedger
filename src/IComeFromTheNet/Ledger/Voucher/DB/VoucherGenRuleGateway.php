<?php
namespace IComeFromTheNet\Ledger\Voucher\DB;

use DBALGateway\Table\AbstractTable;

/**
 * Gateway to the voucher generator rules database table
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class VoucherGenRuleGateway extends AbstractTable
{
    
    
    /**
      *  Create a new instance of the querybuilder
      *
      *  @access public
      *  @return VoucherGenRuleQuery
      */
    public function newQueryBuilder()
    {
        return new VoucherGenRuleQuery($this->adapter,$this);
    }

}
/* End of Class */
