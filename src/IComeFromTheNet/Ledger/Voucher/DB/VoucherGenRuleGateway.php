<?php
namespace IComeFromTheNet\Ledger\Voucher\DB;

use DBALGateway\Table\AbstractTable;
use IComeFromTheNet\Ledger\SchemaAwareTable;

/**
 * Gateway to the voucher generator rules database table
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class VoucherGenRuleGateway extends SchemaAwareTable
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
