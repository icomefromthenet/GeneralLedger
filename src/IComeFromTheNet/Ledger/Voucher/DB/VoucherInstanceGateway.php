<?php
namespace IComeFromTheNet\Ledger\Voucher\DB;

use DBALGateway\Table\AbstractTable;
use IComeFromTheNet\Ledger\SchemaAwareTable;

/**
 * Gateway to the voucher group instance table
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class VoucherInstanceGateway extends SchemaAwareTable
{
    
    
    /**
      *  Create a new instance of the querybuilder
      *
      *  @access public
      *  @return VoucherGroupQuery
      */
    public function newQueryBuilder()
    {
        return new VoucherInstanceQuery($this->adapter,$this);
    }

}
/* End of Class */
