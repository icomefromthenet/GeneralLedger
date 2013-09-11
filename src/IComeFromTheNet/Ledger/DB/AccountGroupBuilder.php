<?php
namespace IComeFromTheNet\Ledger\DB;

use DBALGateway\Builder\BuilderInterface;
use IComeFromTheNet\Ledger\Entity\AccountGroup;

/**
  *  Builds Account Group Entity
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class AccountGroupBuilder
{
    
    /**
      *  Convert data array into entity
      *
      *  @return AccountGroup
      *  @param array $data
      *  @access public
      */
    public function build($data)
    {
        $group = new AccountGroup();
        
        $group->setName($data['group_name']);
        $group->setDescription($data['group_description']);
        $group->setDateAdded($data['group_date_added']);
        $group->setDateRemoved($data['group_date_removed']);
        $group->setGroupID($data['group_id']);
        
        if(isset($data['parent_group_id'])) {
            $group->setParentGroupID($data['parent_group_id']);    
        }
        
        return $group;        
        
    }
    
    /**
      *  Convert and entity into a data array
      *
      *  @return array
      *  @access public
      */
    public function demolish($entity)
    {
        return array(
                'group_name'         => $entity->getName(),
                'group_description'  => $entity->getDescription(),
                'group_date_added'   => $entity->getDateAdded(),
                'group_date_removed' => $entity->getDateRemoved(),
                'group_id'           => $entity->getGroupID(),
                'parent_group_id'    => $entity->getParentGroupID()
            );
    }
    
    
}
/* End of Class */
