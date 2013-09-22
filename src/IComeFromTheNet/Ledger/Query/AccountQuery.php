<?php
namespace IComeFromTheNet\Ledger\Query;

use DateTime;
use DBALGateway\Query\AbstractQuery;
use DBALGateway\Query\QueryInterface;
use IComeFromTheNet\Ledger\Entity\AccountGroup;


/**
  *  Query Builder for Queries to Accounts Table
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class AccountQuery extends AbstractQuery implements QueryInterface
{
    
    
    /**
     *  Filter the result to a single account
     *
     *  @access public
     *  @return AccountQuery
     *  @param integer $accountNumber
     *
    */
    public function filterByAccountNumber($accountNumber)
    {
        $this->where('account_number = :account_number')
             ->setParameter('account_number',
                            $accountNumber,
                            $this->getGateway()->getMetaData()->getColumn('account_number')->getType());
        return $this;
    }
    
    /**
     *  Filter the result to a single account group
     *
     *  @access public
     *  @return AccountQuery
     *  @param AccountGroup $group
     *
    */
    public function filterByAccountGroup($groupID)
    {
        $this->andWhere('account_group_id = :account_group_id')
             ->setParameter('account_group_id',
                            $groupID,
                            $this->getGateway()->getMetaData()->getColumn('account_group_id')->getType());
        return $this;
    }
    
    /**
     *  Filter the result to a list of groups
     *
     *  @access public
     *  @return AccountQuery
     *  @param array[AccountGroup] $groups
     *
    */
    public function filterByAccountGroups(array $groups)
    {
        $this->andWhere('account_group_id IN (:account_group_id)')
             ->setParameter('account_group_id',
                            $groups,
                            $this->getGateway()->getMetaData()->getColumn('account_group_id')->getType());
        return $this;
    }
    
    /**
     *  Used to search for an account By Name
     *
     *  @access public
     *  @param string $name the account name
     *  @return AccountQuery
     *
    */
    public function searchByAccountName($name)
    {
        $this->where($this->expr()->like('account_name','%:account_name%'))
            ->setParameter('account_name',
                           $name,
                           $this->getGateway()->getMetaData()->getColumn('account_name')->getType());
        
        
        return $this;
    }
    
    /**
     *  Filter to only account opened on Date X
     *
     *  @access public
     *  @return AccountQuery
     *  @param DateTime $opened the date the account created
     *
    */
    public function filterByDateOpened(DateTime $opened)
    {
        $this->where('account_date_opened = :account_date_opened')
             ->setParameter('account_date_opened',
                            $opened,
                            $this->getGateway()->getMetaData()->getColumn('account_date_opened')->getType());

        return $this;
    }


    /**
     *  Filter to accounts opened before Date X
     *
     *  @access public
     *  @return AccountQuery
     *  @param DateTime $before cut off date
     *
    */
    public function filterByDateOpenedBefore(DateTime $before)
    {
        $this->andWhere('account_date_opened <= :account_date_opened_before')
             ->setParameter('account_date_opened_before',
                            $before,
                            $this->getGateway()->getMetaData()->getColumn('account_date_opened')->getType()
                        );

        
        return $this;
    }
    
    /**
     *  Filter to accounts opened after Date X
     *
     *  @access public
     *  @return AccountQuery
     *  @param DateTime $after the cut off date
     *
    */
    public function filterByDateOpenedAfter(DateTime $after)
    {
         $this->andWhere('account_date_opened >= :account_date_opened_after')
             ->setParameter('account_date_opened_after',
                            $after,
                            $this->getGateway()->getMetaData()->getColumn('account_date_opened')->getType()
                        );
        
        return $this;
    }
    
    /**
     *  Filter to only account closed on Date X
     *
     *  @access public
     *  @return AccountQuery
     *  @param DateTime $closed the date the account closed
     *
    */
    public function filterByDateClosed(DateTime $closed)
    {
        $this->where('account_date_closed = :account_date_closed')
             ->setParameter('account_date_closed',
                            $closed,
                            $this->getGateway()->getMetaData()->getColumn('account_date_closed')->getType());

        return $this;
    }
    
    /**
     *  Filter to account closed before Date X
     *
     *  @access public
     *  @return AccountQuery
     *  @param DateTime $before the cut off date
     *
    */
    public function filterByDateClosedBefore(DateTime $before)
    {
        
        $this->andWhere('account_date_closed <= :account_date_closed_before')
             ->setParameter('account_date_closed_before',
                            $before,
                            $this->getGateway()->getMetaData()->getColumn('account_date_closed')->getType()
                        );
        
        return $this;
    }
    
    /**
     *  Filter to accounts closed after Date X
     *
     *  @access public
     *  @return AccountQuery
     *  @param DateTime $after the cut off date
     *
    */
    public function filterByDateClosedAfter(DateTime $after)
    {
         $this->andWhere('account_date_closed >= :account_date_closed_after')
             ->setParameter('account_date_closed_after',
                            $after,
                            $this->getGateway()->getMetaData()->getColumn('account_date_closed')->getType()
                        );
        
        return $this;
    }
    
    
    
    
    
    
    
}
/* End of Class */

