<?php
namespace IComeFromTheNet\Ledger\Voucher\DB;

use DBALGateway\Table\AbstractTable;

/**
 * Gateway to the voucher group instance table
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class VoucherInstanceGateway extends AbstractTable
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
