<?php
namespace IComeFromTheNet\Ledger\Test;

use DateTime;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use PHPUnit_Extensions_Database_DataSet_QueryDataSet;
use IComeFromTheNet\Ledger\Test\Base\TestWithContainer;
use IComeFromTheNet\Ledger\Service\AccountManagerService;
use IComeFromTheNet\Ledger\Entity\Account;
use IComeFromTheNet\Ledger\Entity\AccountGroup;
use IComeFromTheNet\Ledger\Exception\LedgerException;
use IComeFromTheNet\Ledger\Test\Base\ArrayDataSet;

/**
  *  Unit test of the Account Manager
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class AccountManagerServiceTest extends TestWithContainer
{
    
    
    public function getDataSet()
    {
        return $this->createXMLDataSet(__DIR__ . DIRECTORY_SEPARATOR . 'Fixture'. DIRECTORY_SEPARATOR .'account_manager_service.xml');
    }

    
    public function testDI()
    {
        $service = $this->getContainer()->getAccountServiceManager();
        $now = new DateTime();
        $this->assertInstanceOf('IComeFromTheNet\Ledger\Service\AccountManagerService',$service);
        
        # Test Properties
        $service->setNow($now);
        $this->assertEquals($now,$service->getNow());
    }
   
   
    public function testSearchAccountReturnsQueryBuilder()
    {
        $this->assertInstanceOf('IComeFromTheNet\Ledger\Query\AccountQuery',$this->getContainer()->getAccountServiceManager()->searchAccounts());
    }
    
    
    public function testSearchGroupReturnsQueryBuilder()
    {
        $this->assertInstanceOf('IComeFromTheNet\Ledger\Query\AccountGroupQuery',$this->getContainer()->getAccountServiceManager()->searchGroups());
    }
   
   
    public function testFindAccountGoodID()
    {
        $service = $this->getContainer()->getAccountServiceManager(); 
        $account = $service->findAccount(1);
        
        $this->assertInstanceOf('IComeFromTheNet\Ledger\Entity\Account',$account);
    }
    
    public function testFindAccountReturnsNullOnBadID()
    {
        $service = $this->getContainer()->getAccountServiceManager(); 
        $this->assertEquals(null,$service->findAccount(999999));
    }
    
    
    public function testFindAccountGroupGoodID()
    {
        $service = $this->getContainer()->getAccountServiceManager(); 
        $account = $service->findGroup(1);
        
        $this->assertInstanceOf('IComeFromTheNet\Ledger\Entity\AccountGroup',$account);
    }
    
    
    public function testFindAccountGroupReturnsNullOnBadID()
    {
        $service = $this->getContainer()->getAccountServiceManager(); 
        $this->assertEquals(null,$service->findGroup(999999));
        
    }
    
    /**
     *  @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     *  @expectedExceptionMessage Can not open account rootAccount as it already exists
     *
    */
    public function testOpenAccountErrorAlreadyExists()
    {
        $service = $this->getContainer()->getAccountServiceManager();
        
        $account = new Account();
        $account->setAccountName('rootAccount');
        $account->setAccountNumber(1);
        $account->setDateOpened(new DateTime());
        $account->setGroupId(1);
        
        $service->openAccount($account);
    }
    
    /**
     *  @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     *  @expectedExceptionMessage Account must have an open date
     *
    */ 
    public function testOpenAccountErrorNoDateOpeneingSupplied()
    {
        $service = $this->getContainer()->getAccountServiceManager();
        
        $account = new Account();
        $account->setAccountName('rootAccount');
        $account->setAccountNumber(101);
        $account->setGroupId(1);
        
        $service->openAccount($account);
    }
    
    /**
     *  @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     *  @expectedExceptionMessage Account must have a unique account number and issued an account name
     *
    */ 
    public function testOpenAccountErrorNoAccountNameSupplied()
    {
        $service = $this->getContainer()->getAccountServiceManager();
        
         
        $account = new Account();
        $account->setDateOpened(new DateTime());
        $account->setAccountNumber(101);
        $account->setGroupId(1);
        
        $service->openAccount($account);
    }
    
    /**
     *  @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     *  @expectedExceptionMessage Account must have a unique account number and issued an account name
     *
    */ 
    public function testOpenAccountErrorNoAccountNumberSupplied()
    {
        $service = $this->getContainer()->getAccountServiceManager();
        
        $service = $this->getContainer()->getAccountServiceManager();
         
        $account = new Account();
        $account->setAccountName('rootAccount');
        $account->setDateOpened(new DateTime());
        $account->setGroupId(1);
        
        $service->openAccount($account);
    }
    
    /**
     *  @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     *  @expectedExceptionMessage Can not open account rootAccount as no group been set
     *
    */ 
    public function testOpenAccountErrorNoGroupSupplied()
    {
        $service = $this->getContainer()->getAccountServiceManager();
         
        $account = new Account();
        $account->setAccountName('rootAccount');
        $account->setAccountNumber(101);
        $account->setDateOpened(new DateTime());
        
        $service->openAccount($account);
        
    }
    
    /**
     *  @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     *  @expectedExceptionMessage Can not open account rootAccount as its group does not exist
     *
    */ 
    public function testOpenAccountErrorGroupNotExist()
    {
        $service = $this->getContainer()->getAccountServiceManager();
         
        $account = new Account();
        $account->setAccountName('rootAccount');
        $account->setAccountNumber(101);
        $account->setDateOpened(new DateTime());
        $account->setGroupId(1000);
        
        $service->openAccount($account);
    }
    
    
    
    public function testAddAccount()
    {
        $startRowCount = $this->getConnection()->getRowCount('ledger_account');
        
        $service = $this->getContainer()->getAccountServiceManager();
         
        $account = new Account();
        $account->setAccountName('rootAccount');
        $account->setAccountNumber(101);
        $account->setDateOpened(new DateTime());
        $account->setGroupId(1);
        
        $this->assertTrue($service->openAccount($account));
        $this->assertEquals(($startRowCount +1), $this->getConnection()->getRowCount('ledger_account'), "Add Account API Operation");
        
        
        $ds1 = new PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $ds1->addTable('ledger_account', 'SELECT account_number,
                                         account_group_id,
                                         account_name,
                                         account_date_opened,
                                         account_date_closed
                                          FROM ledger_account
                                          WHERE account_number = 101;'); 
        
        $ds2 = new ArrayDataSet(array(
            'ledger_account' => array(
                array('account_number'      => $account->getAccountNumber(),
                      'account_group_id'    => $account->getGroupId(),
                      'account_name'        => $account->getAccountName(),
                      'account_date_opened' => $account->getDateOpened()->format('Y-m-d'),
                      'account_date_closed' => $account->getDateClosed()->format('Y-m-d')
                      ),
            ),
        ));
        
        $this->assertDataSetsEqual($ds1, $ds2);
    }
    
    
    /*
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage Account must have a closed date
     */
    public function testCloseAccountErrorNoCloseDate()
    {
        
        $service = $this->getContainer()->getAccountServiceManager();
         
        $account = new Account();
        $account->setAccountName('rootAccount');
        $account->setAccountNumber(101);
        $account->setDateOpened(new DateTime());
        $account->setGroupId(1);
        
        $service->closeAccount($account);
    }
    
    /*
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage Can not close account rootAccount as it does not exist
     */
    public function testCloseAccountErrorAccountNotExist()
    {
        $now    = new DateTime();
        $opened = new DateTime();
        $opened->modify('-3 weeks');
        $closed = new DateTime();
        
        $service = $this->getContainer()->getAccountServiceManager();
        $service->setNow($now);
         
        $account = new Account();
        $account->setAccountName('rootAccount');
        $account->setAccountNumber(10100);
        $account->setDateOpened($opened);
        $account->setClosedDate($closed);
        $account->setGroupId(1);
        
        $service->closeAccount($account);
    }
    
    /*
     * @expectedException IComeFromTheNet\Ledger\Exception\LedgerException
     * @expectedExceptionMessage Can not close account rootAccount as it has already been closed
     */
    public function testCloseAccountAlreadyClosed()
    {
        # set now to far future date    
        $now    = new DateTime();
        $opened = new DateTime();
        $opened->modify('-3 weeks');
        $closed = new DateTime();
        
        $service = $this->getContainer()->getAccountServiceManager();
        $service->setNow($now);
         
        $account = new Account();
        $account->setAccountName('rootAccount');
        $account->setAccountNumber(10100);
        $account->setDateOpened($opened);
        $account->setClosedDate($closed);
        $account->setGroupId(1);
        
        $service->closeAccount($account);
    }
    
    
    
    
}
/* End of Class */