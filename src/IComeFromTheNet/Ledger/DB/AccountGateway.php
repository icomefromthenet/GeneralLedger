<?php
namespace IComeFromTheNet\Ledger\DB;

use DBALGateway\Table\AbstractTable;
use DBALGateway\Table\TableInterface;
use IComeFromTheNet\Ledger\Query\AccountQuery;

/**
  *  Account TableGateway
  *
  *  Map entity to database
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class AccountGateway extends AbstractTable implements TableInterface 
{
    
    /**
      *  Create a new instance of the querybuilder
      *
      *  @access public
      *  @return IComeFromTheNet\Ledger\Query\AccountGroupQuery
      */
    public function newQueryBuilder()
    {
        return new AccountQuery($this->adapter,$this);
    }
    
    
}
