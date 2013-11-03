<?php
namespace IComeFromTheNet\Ledger\DB;

use Aura\Marshal\Manager;
use Aura\Marshal\Type\Builder as TypeBuilder;
use Aura\Marshal\Relation\Builder as RelationBuilder;

use IComeFromTheNet\Ledger\DB\AccountBuilder;
use IComeFromTheNet\Ledger\DB\AccountGroupBuilder;

/**
  *  Setup Aura Marshal
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class MarshalManager
{
    
    
    protected $accountBuilder;
    
    protected $accountGroupBuilder;
    
    /**
     *  Class Constructor
     *
     *  @access public
     *  @return void
     *  @param AccountBuilder $accountBuilder
     *  @param AccountGroupBuilder $accountGroupBuilder
     *
    */
    public function __construct(AccountBuilder $accountBuilder, AccountGroupBuilder $accountGroupBuilder)
    {
        $this->accountBuilder 		= $accountBuilder;
	$this->accountGroupBuilder 	= $accountGroupBuilder;
        
    }
    
    
    /**
     *  Configure the Aura Marshal component    
     *
     *  @access public
     *  @return Aura\Marshal\Manager
     *
    */    
    public function configure()
    {
        $manager = new Manager(
            new TypeBuilder(),
            new RelationBuilder()
        );
    
        $this->configureTypes($manager);
        $this->configureRelations($manager);
    
        return $manager;
            
    }
    
    
    protected function configureTypes(Manager $manager)
    {
        $manager->setType('accountGroups', array ('identity_field' => 'account_group_id','entity_builder' => $this->accountBuilder));
	$manager->setType('accounts', array('identity_field'=>'account_number','entity_builder' => $this->accountGroupBuilder));

	$manager->setType('entryTags',array('identity_field' => 'tag_id'));
	$manager->setType('ledgerTransactions',array('identity_field'=>'ledger_transaction_id'));
	$manager->setType('ledgerEntries', array('identity_field' => 'ledger_entry_id'));
	
	$manager->setType('costCentres',array('identity_field'=>'cost_centre_id'));

	$manager->setType('statements',array('identity_field'=>'statement_id'));
	$manager->setType('statementPeriods',array('identity_field'=>'period_id'));
	$manager->setType('statementEntries',array('identity_field'=>'entry_id'));
	$manager->setType('statementSchedules',array('identity_field'=>'statement_schedule_id'));
    }
    
    
    protected function configureRelations(Manager $manager)
    {
        
	# relationship between an account and the group it belongs
	$manager->setRelation('accounts', 'accountGroup', array(
    		'relationship'  => 'belongs_to',
		'native_type'   => 'accounts',
		'foreign_type'  => 'accountGroups',
    		'native_field'  => 'account_group_id',
    		'foreign_field' => 'account_group_id',
	));
	
	
        
	# relationship between group and accounts that belong to it
	$manager->setRelation('accountGroups','accounts',array(
		'relationship' => 'has_many',
		'native_type'  => 'accountGroups',
		'foreign_type' => 'accounts',
		'native_field' => 'account_group_id',
		'foreign_field'=> 'account_group_id'
	));
	
	# relationship between accountGroup and its parentGroup
	$manager->setRelation('accountGroups','parentGroup',array(
		'relationship' => 'has_one',
		'native_type'  => 'accountGroups',
		'foreign_type' => 'accountGroups',
		'native_field' => 'parent_group_id',
		'foreign_field'=> 'account_group_id'
	));
	
	/*
	# relationship between ledgerTransaction and the entries that make it up
	$manager->setRelation('ledgerTransactions','ledgerEntries',array(
		'relationship' => 'has_many',
		'native_type'  => 'ledgerTransactions',
		'foreign_type' => 'ledgerEntries',
		'native_field' => 'transaction_id',
		'foreign_field'=> 'transaction_id'
	));

	# relationship between ledgerEntery and the transaction in which it belongs 
	$manager->setRelation('ledgerEntries','ledgerTransaction', array(
		'relationship'  => 'belongs_to',
                'foreign_type'  => 'ledgerTransactions',
                'native_type'   => 'ledgerEntries',
		'native_field'  => 'transaction_id',
		'foreign_field' => 'transaction_id'
	));
    
    
	# relationship between ledgerTransaction and LedgerTag it belongs to
	$manager->setRelation('ledgerTransactions','ledgerTag', array(
		'relationship'  => 'belongs_to',
                'foreign_type'  => 'ledgerTag',
                'native_type'   => 'ledgerTransactions',
		'native_field'  => 'tag_id',
		'foreign_field' => 'tag_id'
	));
    
    
	# relationship between ledgerTranscation and the costCenter its assigned.
	$manager->setRelation('ledgerTransactions','costCenter', array(
		'relationship'  => 'belongs_to',
                'foreign_type'  => 'costCenters',
                'native_type'   => 'ledgerTransactions',
		'native_field'  => 'cost_centre_id',
		'foreign_field' => 'cost_centre_id'
	));
    
    
	# relationship between statement and it has statementPeriods
	$manager->setRelation('statements','statementPeriod', array(
		'relationship'  => 'belongs_to',
                'foreign_type'  => 'statementPeriods',
                'native_type'   => 'statements',
		'native_field'  => 'period_id',
		'foreign_field' => 'period_id'
	));
    
    
	# relationship between statement and the statementEntries that make it up
	$manager->setRelation('statements','statementEntries', array(
		'relationship'  => 'has_many',
                'foreign_type'  => 'statementEntries',
                'native_type'   => 'statements',
		'native_field'  => 'statement_id',
		'foreign_field' => 'statement_id'
	));
	
	
	# relationship between statementEnteries and the statement in which it belongs
	$manager->setRelation('statementEntries','statement', array(
		'relationship'  => 'belongs_to',
                'foreign_type'  => 'statements',
                'native_type'   => 'statementEntries',
		'native_field'  => 'statement_id',
		'foreign_field' => 'statement_id'
	));
	*/
	
	# relationship between statement and the statementSchedule 
	$manager->setRelation('statements','statementSchedule', array(
		'relationship'  => 'belongs_to',
                'foreign_type'  => 'statementSchedules',
                'native_type'   => 'statements',
		'native_field'  => 'statement_schedule_id',
		'foreign_field' => 'statement_schedule_id'
	)); 
    }
    
    
}
/* End of Class */
