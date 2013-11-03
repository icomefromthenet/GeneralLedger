<?php
namespace IComeFromTheNet\Ledger\DB;

use DBALGateway\Builder\BuilderInterface;
use IComeFromTheNet\Ledger\Entity\Account;
use IComeFromTheNet\Ledger\Entity\AccountGroup;
use Aura\Marshal\Entity\BuilderInterface as EntityBuilderInterface;

/**
  *  Builds an Account Entity
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class AccountBuilder implements BuilderInterface,EntityBuilderInterface
{
    
     /**
     * 
     * Creates a new entity object.
     * 
     * @param array $data Data to load into the entity.
     * @return Account
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
      *  @return Account
      *  @param array $data
      *  @access public
      */
    public function build($data)
    {
        $account = new Account();
        
        $account->setAccountNumber($data['account_number']);
        $account->setAccountName($data['account_name']);
        $account->setDateOpened($data['account_date_opened']);
        $account->setDateClosed($data['account_date_closed']);
        
        # account group is managed via the marshaler        
        
        return $account;        
        
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
                'account_number'      => $entity->getAccountNumber(),
                'account_name'        => $entity->getAccountName(),
                'account_date_opened' => $entity->getDateOpened(),
                'account_date_closed' => $entity->getDateClosed(),
                
            );
    
        if($entity->getAccountGroup() instanceof AccountGroup) {
            $data['account_group_id']  = $entity->getAccountGroup()->getGroupID();
        }
        
        return $data;
    }
    
    
}
/* End of Class */
