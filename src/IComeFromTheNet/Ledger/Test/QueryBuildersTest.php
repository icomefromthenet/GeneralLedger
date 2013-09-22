<?php
namespace IComeFromTheNet\Ledger\Test;

use DateTime;
use DateInterval;
use Doctrine\DBAL\Connection;
use DBALGateway\Table\TableInterface;
use IComeFromTheNet\Ledger\Query\AccountGroupQuery;
use IComeFromTheNet\Ledger\Query\AccountQuery;
use IComeFromTheNet\Ledger\Test\Base\TestWithContainer;

/**
  *  Unit test of the QueryBuilders
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class QueryBuildersTest extends TestWithContainer
{
    
    
    
    
    
    public function testAccountGroupQuery()
    {
        $now       = new DateTime();                  
        $container = $this->getContainer();                  
    
        # test filter by Group (filter By ID)
        $query = new AccountGroupQuery($container->getDoctrineDBAL(),$container->getAccountGroupTableGateway());
        $query->select('*')->filterByGroup(1);
        $this->assertEquals(1,$query->getParameter('group_id'));
        $this->assertEquals('SELECT * FROM  WHERE group_id = :group_id',$query->getSQL());
        
        # test Filter By Parent Group
        $query = new AccountGroupQuery($container->getDoctrineDBAL(),$container->getAccountGroupTableGateway());
        $query->select('*')->filterByParentGroup(1);
        $this->assertEquals(1,$query->getParameter('parent_group_id'));
        $this->assertEquals('SELECT * FROM  WHERE parent_group_id = :parent_group_id',$query->getSQL());
        
        # test filter By Date Created
        $query = new AccountGroupQuery($container->getDoctrineDBAL(),$container->getAccountGroupTableGateway());
        $query->select('*')->filterByDateCreated($now);
        $this->assertEquals($now,$query->getParameter('group_date_added'));
        $this->assertEquals('SELECT * FROM  WHERE group_date_added = :group_date_added',$query->getSQL());
        
        # test filter By Date Removed
        $query = new AccountGroupQuery($container->getDoctrineDBAL(),$container->getAccountGroupTableGateway());
        $query->select('*')->filterByDateRemoved($now);
        $this->assertEquals($now,$query->getParameter('group_date_removed'));
        $this->assertEquals('SELECT * FROM  WHERE group_date_removed = :group_date_removed',$query->getSQL());
        
        # test filter By Current
        $query = new AccountGroupQuery($container->getDoctrineDBAL(),$container->getAccountGroupTableGateway());
        $query->select('*')->filterOnlyCurrent($now);
        $this->assertEquals($now,$query->getParameter('group_date_added_current'));
        $this->assertEquals($now,$query->getParameter('group_date_removed_current'));
        $this->assertEquals('SELECT * FROM  WHERE (group_date_added < :group_date_added_current) AND (group_date_removed < :group_date_removed_current)',$query->getSQL());
        
        
        # test filter by Created Before
        $query = new AccountGroupQuery($container->getDoctrineDBAL(),$container->getAccountGroupTableGateway());
        $query->select('*')->filterByDateCreatedBefore($now);
        $this->assertEquals($now,$query->getParameter('group_date_added_before'));
        $this->assertEquals('SELECT * FROM  WHERE group_date_added <= :group_date_added_before',$query->getSQL());
        
        # test filter by Created After
        $query = new AccountGroupQuery($container->getDoctrineDBAL(),$container->getAccountGroupTableGateway());
        $query->select('*')->filterByDateCreatedAfter($now);
        $this->assertEquals($now,$query->getParameter('group_date_added_after'));
        $this->assertEquals('SELECT * FROM  WHERE group_date_added >= :group_date_added_after',$query->getSQL());
        
        # test filter by Removed Before
        $query = new AccountGroupQuery($container->getDoctrineDBAL(),$container->getAccountGroupTableGateway());
        $query->select('*')->filterByDateRemovedBefore($now);
        $this->assertEquals($now,$query->getParameter('group_date_removed_before'));
        $this->assertEquals('SELECT * FROM  WHERE group_date_removed <= :group_date_removed_before',$query->getSQL());
        
        # test filter by Removed After
        $query = new AccountGroupQuery($container->getDoctrineDBAL(),$container->getAccountGroupTableGateway());
        $query->select('*')->filterByDateRemovedAfter($now);
        $this->assertEquals($now,$query->getParameter('group_date_removed_after'));
        $this->assertEquals('SELECT * FROM  WHERE group_date_removed >= :group_date_removed_after',$query->getSQL());
        
        # test filter Range Created Before & After
        $query = new AccountGroupQuery($container->getDoctrineDBAL(),$container->getAccountGroupTableGateway());
        $query->select('*')->filterByDateCreatedBefore($now)->filterByDateCreatedAfter($now);
        $this->assertEquals($now,$query->getParameter('group_date_added_after'));
        $this->assertEquals($now,$query->getParameter('group_date_added_before'));
        $this->assertEquals('SELECT * FROM  WHERE (group_date_added <= :group_date_added_before) AND (group_date_added >= :group_date_added_after)',$query->getSQL());
        
        # test filter Range Removed Before & After
        $query = new AccountGroupQuery($container->getDoctrineDBAL(),$container->getAccountGroupTableGateway());
        $query->select('*')->filterByDateRemovedBefore($now)->filterByDateRemovedAfter($now);
        $this->assertEquals($now,$query->getParameter('group_date_removed_after'));
        $this->assertEquals($now,$query->getParameter('group_date_removed_before'));
        $this->assertEquals('SELECT * FROM  WHERE (group_date_removed <= :group_date_removed_before) AND (group_date_removed >= :group_date_removed_after)',$query->getSQL());
        
    }
    
    
    public function testAccountQueryBuilder()
    {
        
        $container = $this->getContainer();
        
        $doctrineDBAL = $container->getDoctrineDBAL();
        $gateway      = $container->getAccountTableGateway();
        
        # test filter by Account Number
        $query = new AccountQuery($doctrineDBAL,$gateway);
        $accountNumber = 100;
        $query->filterByAccountNumber($accountNumber)->select('*');
        $this->assertEquals($accountNumber,$query->getParameter('account_number'));
        $this->assertEquals('SELECT * FROM  WHERE account_number = :account_number',$query->getSQL());
        
        # test filter by Account Group
        $query = new AccountQuery($doctrineDBAL,$gateway);
        $accountGroup = 1;
        $query->filterByAccountGroup($accountGroup)->select('*');
        $this->assertEquals($accountGroup,$query->getParameter('account_group_id'));
        $this->assertEquals('SELECT * FROM  WHERE account_group_id = :account_group_id',$query->getSQL());
        
        # test filter By Many Account Groups
        # doctrine DBAL will convert IN param to a list.
        # this test only query builder
        $query = new AccountQuery($doctrineDBAL,$gateway);
        $accountGroup = array(1,2,3);
        $query->filterByAccountGroups($accountGroup)->select('*');
        $this->assertEquals($accountGroup,$query->getParameter('account_group_id'));
        $this->assertEquals('SELECT * FROM  WHERE account_group_id IN (:account_group_id)',$query->getSQL());
        
        # test filter by Account Name (Like)
        $query = new AccountQuery($doctrineDBAL,$gateway);
        $accountName = 'aaa';
        $query->searchByAccountName($accountName)->select('*');
        $this->assertEquals($accountName,$query->getParameter('account_name'));
        $this->assertEquals('SELECT * FROM  WHERE account_name LIKE %:account_name%',$query->getSQL());
        
        # test filter by date account opened
        $query = new AccountQuery($doctrineDBAL,$gateway);
        $accountOpened = new DateTime();
        $query->filterByDateOpened($accountOpened)->select('*');
        $this->assertEquals($accountOpened,$query->getParameter('account_date_opened'));
        $this->assertEquals('SELECT * FROM  WHERE account_date_opened = :account_date_opened',$query->getSQL());
        
        
        # test filter by date account closed
        $query = new AccountQuery($doctrineDBAL,$gateway);
        $accountClosed = new DateTime();
        $query->filterByDateClosed($accountClosed)->select('*');
        $this->assertEquals($accountClosed,$query->getParameter('account_date_closed'));
        $this->assertEquals('SELECT * FROM  WHERE account_date_closed = :account_date_closed',$query->getSQL());
        
        # test filter by account opened before
        $query = new AccountQuery($doctrineDBAL,$gateway);
        $accountBefore = new DateTime();
        $query->filterByDateOpenedBefore($accountBefore)->select('*');
        $this->assertEquals($accountBefore,$query->getParameter('account_date_opened_before'));
        $this->assertEquals('SELECT * FROM  WHERE account_date_opened <= :account_date_opened_before',$query->getSQL());
        
        # test filter by account opened after
        $query = new AccountQuery($doctrineDBAL,$gateway);
        $accountAfter = new DateTime();
        $query->filterByDateOpenedAfter($accountAfter)->select('*');
        $this->assertEquals($accountAfter,$query->getParameter('account_date_opened_after'));
        $this->assertEquals('SELECT * FROM  WHERE account_date_opened >= :account_date_opened_after',$query->getSQL());
        
        # test filter by open range
        $query = new AccountQuery($doctrineDBAL,$gateway);
        $accountAfter = new DateTime();
        $accountBefore = new DateTime();
        $query->filterByDateOpenedAfter($accountAfter)
              ->filterByDateOpenedBefore($accountBefore)
              ->select('*');
        $this->assertEquals($accountAfter,$query->getParameter('account_date_opened_after'));
        $this->assertEquals($accountAfter,$query->getParameter('account_date_opened_before'));
        $this->assertEquals('SELECT * FROM  WHERE (account_date_opened >= :account_date_opened_after) AND (account_date_opened <= :account_date_opened_before)',$query->getSQL());
        
        # test filter by account closed before
        $query = new AccountQuery($doctrineDBAL,$gateway);
        $accountBefore = new DateTime();
        $query->filterByDateClosedBefore($accountBefore)->select('*');
        $this->assertEquals($accountBefore,$query->getParameter('account_date_closed_before'));
        $this->assertEquals('SELECT * FROM  WHERE account_date_closed <= :account_date_closed_before',$query->getSQL());
       
        
        # test filter by account closed after
        $query = new AccountQuery($doctrineDBAL,$gateway);
        $accountAfter = new DateTime();
        $query->filterByDateClosedAfter($accountAfter)->select('*');
        $this->assertEquals($accountAfter,$query->getParameter('account_date_closed_after'));
        $this->assertEquals('SELECT * FROM  WHERE account_date_closed >= :account_date_closed_after',$query->getSQL());
        
        
        # test filter by account closed range
        $query = new AccountQuery($doctrineDBAL,$gateway);
        $accountAfter = new DateTime();
        $accountBefore = new DateTime();
        $query->filterByDateClosedAfter($accountAfter)
              ->filterByDateClosedBefore($accountBefore)
              ->select('*');
        $this->assertEquals($accountAfter,$query->getParameter('account_date_closed_after'));
        $this->assertEquals($accountAfter,$query->getParameter('account_date_closed_before'));
        $this->assertEquals('SELECT * FROM  WHERE (account_date_closed >= :account_date_closed_after) AND (account_date_closed <= :account_date_closed_before)',$query->getSQL());
       
    }
    
}