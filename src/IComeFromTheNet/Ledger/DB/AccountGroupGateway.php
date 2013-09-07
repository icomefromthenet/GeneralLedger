<?php
namespace IComeFromTheNet\Ledger\DB;

use DBALGateway\Table\AbstractTable;
use DBALGateway\Table\TableInterface;
use IComeFromTheNet\Ledger\Query\AccountGroupQuery;

/**
  *  AccountGroups TableGateway
  *
  *  Map entity to database
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class AccountGroupGateway extends AbstractTable implements TableInterface 
{
    
    /**
      *  Create a new instance of the querybuilder
      *
      *  @access public
      *  @return IComeFromTheNet\Ledger\Query\AccountGroupQuery
      */
    public function newQueryBuilder()
    {
        return new AccountGroupQuery($this->adapter,$this);
    }
    
    
}
