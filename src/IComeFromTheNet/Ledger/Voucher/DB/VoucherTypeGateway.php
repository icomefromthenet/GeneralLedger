<?php
namespace IComeFromTheNet\Ledger\Voucher\DB;

use DBALGateway\Table\AbstractTable;
use IComeFromTheNet\Ledger\SchemaAwareTable;


/**
  *  Voucher Type TableGateway
  *
  *  Map entity to database
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class VoucherTypeGateway extends SchemaAwareTable
{
    
    /**
      *  Create a new instance of the querybuilder
      *
      *  @access public
      *  @return IComeFromTheNet\Ledger\Query\AccountGroupQuery
      */
    public function newQueryBuilder()
    {
        return new VoucherTypeQuery($this->adapter,$this);
    }
    
    
    
}
/* End of Class */