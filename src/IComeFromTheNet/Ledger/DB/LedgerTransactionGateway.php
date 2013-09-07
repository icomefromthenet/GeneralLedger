<?php
namespace IComeFromTheNet\Ledger\DB;

use DBALGateway\Table\AbstractTable;
use DBALGateway\Table\TableInterface;
use IComeFromTheNet\Ledger\Query\LedgerTransactionQuery;

/**
  *  Table Gateway for Ledger Transaction
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class LedgerTransactionGateway extends AbstractTable implements TableInterface 
{
    
    /**
      *  Create a new instance of the querybuilder
      *
      *  @access public
      *  @return IComeFromTheNet\Ledger\Query\LedgerTransactionQuery
      */
    public function newQueryBuilder()
    {
        return new LedgerTransactionQuery($this->adapter,$this);
    }
    
    
}
