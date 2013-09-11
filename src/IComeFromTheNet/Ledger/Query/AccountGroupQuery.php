<?php
namespace IComeFromTheNet\Ledger\Query;

use DBALGateway\Query\AbstractQuery;
use DBALGateway\Query\QueryInterface;

/**
  *  Query Builder for Queries to AccountGroup Table
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class AccountGroupQuery extends AbstractQuery implements QueryInterface
{
    
    
    /**
     *  Filter the select by parent group
     *
     *  @access public
     *  @return AccountGroupQuery
     *  @param integer $id the parent group id
     *
    */
    public function filterByParentGroup($id)
    {
        $this->where('parent_group_id = :parent_group_id')
             ->setParameter('parent_group_id',
                            $id,
                            $this->getGateway()->getMetaData()->getColumn('parent_group_id')->getType()
                        );
        return $this;
    }

    /**
     *  Filter to a single group, ie return row by pk
     *
     *  @access public
     *  @return AccountGroupQuery
     *  @param integer $id the group_id to select
     *
    */
    public function filterByGroup($id)
    {
        $this->where('group_id = :group_id')
             ->setParameter('group_id',
                            $id,
                            $this->getGateway()->getMetaData()->getColumn('group_id')->getType()
                        );

        return $this;
    }

     /**
     *  Filter to groups added on this date
     *
     *  @access public
     *  @return AccountGroupQuery
     *  @param DateTime $created
     *
    */
    public function filterByDateCreated(DateTime $created)
    {
        $this->where('group_date_added = :group_date_added')
             ->setParameter('group_date_added',
                            $created,
                            $this->getGateway()->getMetaData()->getColumn('group_date_added')->getType()
                        );

        return $this;
    }
    
    /**
     *  Filter to groups removed on this date
     *
     *  @access public
     *  @return AccountGroupQuery
     *  @param DateTime $updated
     *
    */
    public function filterByDateRemoved(DateTime $updated)
    {
        $this->where('group_date_removed = :group_date_removed')
             ->setParameter('group_date_removed',
                            $updated,
                            $this->getGateway()->getMetaData()->getColumn('group_date_removed')->getType());

        return $this;
    }
    
    /**
     *  Filter To only groups that are current
     *  Current Accounts where now within range of opening and closing
     *  Using closed/closed range test
     *
     *  @access public
     *  @return AccountGroupQuery
     *  @param DateTime $now the current time
     *
    */
    public function filterOnlyCurrent(DateTime $now)
    {
        $this->where('group_date_added < :group_date_added_current')
             ->setParameter('group_date_added_current',
                            $now,
                            $this->getGateway()->getMetaData()->getColumn('group_date_added')->getType()
                        );
        $this->where('group_date_removed < :group_date_removed_current')
             ->setParameter('group_date_removed_current',
                            $now,
                            $this->getGateway()->getMetaData()->getColumn('group_date_removed')->getType());
             
        return $this;
    }
    
    
}
/* End of Class */

