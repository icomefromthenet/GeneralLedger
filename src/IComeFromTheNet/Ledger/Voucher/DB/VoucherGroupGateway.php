<?php
namespace IComeFromTheNet\Ledger\Voucher\DB;

use DBALGateway\Table\AbstractTable;
use IComeFromTheNet\Ledger\SchemaAwareTable;


/**
 * Gateway to the voucher group database table
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class VoucherGroupGateway extends SchemaAwareTable
{
    
    
    /**
      *  Create a new instance of the querybuilder
      *
      *  @access public
      *  @return VoucherGroupQuery
      */
    public function newQueryBuilder()
    {
        return new VoucherGroupQuery($this->adapter,$this);
    }

}
/* End of Class */
