<?php
namespace IComeFromTheNet\Ledger\Test;

use DateTime;
use DateInterval;
use IComeFromTheNet\Ledger\DB\MarshalManager;



/**
  *  Unit test of the Marshal Code
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class MarshalTest extends \PHPUnit_Framework_TestCase
{
    
    
    
    public function testConfigurtionClass()
    {
        $configure = new MarshalManager();
        $manager   = $configure->configure();
    }
    
    
    
    public function testRelationShipLoading()
    {
        $configure = new MarshalManager();
        $manager   = $configure->configure();
        
        # test if we can load accounts into field
        $manager->accounts->load(array(array('account_number'=>100,'account_group_id' =>1),
                                       array('account_number'=> 5,'account_group_id' =>1))
                                 );
        
        $accounts = $manager->accounts->getCollection(array(100,5));
        
        $this->assertEquals(100,$accounts[0]->account_number);
        $this->assertEquals(5,$accounts[1]->account_number);
        
        $manager->accountGroups->load(array(
                                   array('account_group_id' => 1,'a'=> 'c'),         
                                   array('account_group_id' => 2,'a' =>'c'),         
                                ));
        
        $groups = $manager->accountGroups->getCollection(array(1,2));
        
        $this->assertEquals(1,$groups[0]->account_group_id);
        $this->assertEquals(2,$groups[1]->account_group_id);
        

        # test the relationship account has account group
        
        $this->assertEquals(1,$accounts[0]->accountGroup->account_group_id);
        $this->assertEquals(1,$accounts[1]->accountGroup->account_group_id);
        
        $this->assertEquals($groups[0]->account_group_id,$accounts[0]->accountGroup->account_group_id);
        
        # test a relation ship accountGroup has accounts
        $this->assertEquals(100,$groups[0]->accounts[0]->account_number);
        $this->assertEquals(5,$groups[0]->accounts[1]->account_number);
        
        $entity = new \Aura\Marshal\Entity\GenericEntity();
        
    }
    
    
    
}
/* End of Class */