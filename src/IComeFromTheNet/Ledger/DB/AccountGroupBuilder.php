<?php
namespace IComeFromTheNet\Ledger\DB;

use DBALGateway\Builder\BuilderInterface;
use IComeFromTheNet\Ledger\Entity\AccountGroup;
use Aura\Marshal\Entity\BuilderInterface as EntityBuilderInterface;

/**
  *  Builds Account Group Entity, by mapping database columns to entity fields
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class AccountGroupBuilder implements BuilderInterface, EntityBuilderInterface
{
    
   
    /**
     * 
     * Creates a new entity object.
     * 
     * @param array $data Data to load into the entity.
     * @return AccountGroup
     * @access public
     * 
     */
    public function newInstance(array $data)
    {
        return $this->build($data);
    }
   
   
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
        
        $group->setGroupName($data['group_name']);
        $group->setGroupDescription($data['group_description']);
        $group->setDateAdded($data['group_date_added']);
        $group->setDateRemoved($data['group_date_removed']);
        $group->setGroupID($data['group_id']);
        
        # parent group is not included, but mapped via the marshaler
        
        
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
        $data = array(
                'group_name'         => $entity->getGroupName(),
                'group_description'  => $entity->getGroupDescription(),
                'group_date_added'   => $entity->getDateAdded(),
                'group_date_removed' => $entity->getDateRemoved(),
                'group_id'           => $entity->getGroupID(),
                
            );
        
        if($entity->getParentGroup() instanceof AccountGroup) {
            $data['parent_group_id']  = $entity->getParentGroup()->getGroupID();    
        }
        
        return $data;
    }
    
    
}
/* End of Class */
