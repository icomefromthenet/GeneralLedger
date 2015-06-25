<?php
namespace IComeFromTheNet\Ledger\Voucher;

use IComeFromTheNet\Ledger\Voucher\VoucherQuery;
use DBALGateway\Table\AbstractTable;
use DBALGateway\Table\TableInterface;
use Doctrine\DBAL\Schema\Schema;

/**
  *  Voucher TableGateway
  *
  *  Map entity to database
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class VoucherGateway extends AbstractTable implements TableInterface
{
    
    /**
      *  Create a new instance of the querybuilder
      *
      *  @access public
      *  @return IComeFromTheNet\Ledger\Query\AccountGroupQuery
      */
    public function newQueryBuilder()
    {
        return new VoucherQuery($this->adapter,$this);
    }
    
    
    /**
     *  Get the Doctine schema Model for the voucher table
     *  
     * @return Doctrine\DBAL\Schema\Table
     * @param Schema $sc
     * @param string $prefix
     */
    static public function getModel(Schema $sc,$prefix)
    {
        $table = $sc->createTable($prefix."ledger_voucher");

        $table->addColumn('voucher_slug','string',array('length'=>150));
        $table->addColumn("voucher_enabled_from", "datetime",array());
        $table->addColumn("voucher_enabled_to", "datetime",array());
        $table->addColumn('voucher_name','string',array('length'=>100));
        $table->addColumn('voucher_description','string',array('length'=>500));
        $table->addColumn('voucher_prefix','string',array('length'=> 20));
        $table->addColumn('voucher_suffix','string',array('length'=>20));
        $table->addColumn('voucher_maxlength','integer',array('unsiged'=> true));
        $table->addColumn('voucher_formatter','string',array('length'=> 100));
        $table->addColumn('voucher_sequence_strategy','string',array('length'=> 20));
        $table->addColumn('voucher_sequence_no','integer',array('unsiged'=> true));
        $table->addColumn('voucher_sequence_padding_char','string',array('legnth'=>'1'));
        
        $table->setPrimaryKey(array('voucher_slug','voucher_enabled_from'));
        
    }
    
    
}
/* End of Class */