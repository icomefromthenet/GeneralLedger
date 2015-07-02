<?php
namespace IComeFromTheNet\Ledger\Voucher;

use Pimple\Pimple;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;

/**
 * Voucher Service Container
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0.0
 */ 
class VoucherContainer extends Pimple
{
    
    /**
     *  These constants are the internal names of the table
     *  and are the key columns in the map
     */
     
    const DB_TABLE_VOUCHER_TYPE     = 'voucher_type' ;
    const DB_TABLE_VOUCHER_GROUP    = 'voucher_group' ;
    const DB_TABLE_VOUCHER_INSTANCE = 'voucher_instance' ;
    const DB_TABLE_VOUCHER_RULE     = 'voucher_gen_rule';
    
    
    /**
     * Return the modules database metadata.
     * 
     * This not record FK or other indexes.
     * 
     * @return Doctrine\DBAL\Schema\Schema
     * @param array $tableNameMap Map of internal names to configured names
     */ 
    protected function createModuleDBMeta(array $tableNameMap)
    {
        $sc = new Schema();
        
        
        $sGroupTableName    = $tableNameMap[self::DB_TABLE_VOUCHER_GROUP];
        $sInstanceTableName = $tableNameMap[self::DB_TABLE_VOUCHER_INSTANCE];
        $sRuleTableName     = $tableNameMap[self::DB_TABLE_VOUCHER_RULE];
        $sTypeTableName     = $tableNameMap[self::DB_TABLE_VOUCHER_TYPE];
        
        # Voucher Groups
        $table = $sc->createTable($sGroupTableName);
        $table->addColumn('voucher_group_id','integer',array("unsigned" => true));
        $table->addColumn('voucher_group_name','string',array("length" => 100));
        $table->addColumn('voucher_group_slug','string',array("length" => 100));
        $table->addColumn('is_disabled','boolean',array("default"=>false));
        $table->addColumn('sort_order','integer',array("unsigned" => true));
        $table->addColumn('date_created','datetime',array());
        
        $table->setPrimaryKey(array('voucher_group_id'));
        
        
        # Voucher Rules
        $table = $sc->createTable($sRuleTableName);
        $table->addColumn('voucher_rule_name','string',array('length'=> 25));
        $table->addColumn('voucher_gen_rule_id','integer',array('unsigned'=> true));
        $table->addColumn('voucher_sequence_padding_char','string',array('legnth'=>'1'));
        $table->addColumn('voucher_prefix','string',array('length'=> 20));
        $table->addColumn('voucher_suffix','string',array('length'=>20));
        $table->addColumn('voucher_maxlength','integer',array('unsigned'=> true));
        
        $table->setPrimaryKey(array('voucher_gen_rule_id'));
        
        # Voucher Type Table
        $table = $sc->createTable($sTypeTableName);
        $table->addColumn('voucher_id','integer',array("unsigned" => true));
        $table->addColumn("voucher_enabled_from", "datetime",array());
        $table->addColumn("voucher_enabled_to", "datetime",array());
        $table->addColumn('voucher_name','string',array('length'=>100));
        $table->addColumn('voucher_description','string',array('length'=>500));
        $table->addColumn('voucher_formatter','string',array('length'=> 100));
        $table->addColumn('voucher_sequence_strategy','string',array('length'=> 20));
        $table->addColumn('voucher_sequence_no','integer',array('unsigned'=> true));
        $table->addColumn('voucher_group_id','integer',array('unsigned'=> true));
        $table->addColumn('voucher_gen_rule_id','integer',array('unsigned'=> true));
        
        
        $table->setPrimaryKey(array('voucher_id'));
        
        
        # Vouchers Table (Instance Table)
        $table = $sc->createTable($sInstanceTableName);
        $table->addColumn('voucher_instance_id','integer',array("unsigned" => true));
        $table->addColumn('voucher_id','integer',array("unsigned" => true));
        $table->addColumn('voucher_full_name','string',array("length"=> 255));
        $table->addColumn('date_created','datetime',array());
        
        $table->setPrimaryKey(array('voucher_instance_id'));
        
        return $sc;
        
    }
    
    
    /**
     * DI Container constrcutor
     * 
     * @param Doctrine\DBAL\Connection  $db The Database connection
     * @param array $tableMap   a map of internal table names to actual names
     * @param 
     */ 
    public function __construct(Connection $db ,array $tableMap) 
    {
        $this['database']    = $db;
        $this['tableMap']    = $tableMap;
        
    }
    
    
    /**
     * Return the assigned database adapter
     * 
     * @return Doctrine\DBAL\Connection
     */ 
    public function getDatabaseAdapter()
    {
        return $this['database'];
    }
    
    
    /**
     * 
     * 
     */ 
    public function getVoucherGroupGateway()
    {
        return $this['gatewayVoucherGroup'];
    }
    
    /**
     * 
     * 
     */ 
    public function getVoucherTypeGateway()
    {
        return $this['gatewayVoucherType'];
    }
    
    
    /**
     * 
     * 
     */ 
    public function getVoucherInstanceGateway()
    {
        return $this['gatewayVoucherInstance'];
    }
    
    /**
     * 
     * 
     */ 
    public function getVoucherRuleGateway()
    {
        return $this['gatewayVoucherRule'];
    }
    
    
    //--------------------------------------------------------------------------
    # Service Bootstrap
    
    
    /**
     *  Build this services dependecies, only call once
     *  
     * @return void
     */ 
    public function bootstrap()
    {
        
        # build the table meta data using the map  
        $this['dbMeta'] = $this->createModuleDBMeta($this['tableMap']);
        
        
        # instance the gateways
        
        $this['gatewayVoucherGroup'] = $this->share(function($c) {
            
            
        });
        
        $this['gatewayVoucherType'] = $this->share(function($c) {
            
            
        });
        
        $this['gatewayVoucherInstance'] = $this->share(function($c) {
            
            
        });
        
        
        $this['gatewayVoucherRule'] = $this->share(function($c) {
            
            
        });
        
        # instance the other
        
        
     
        
    }
    
}
/* End of File /*