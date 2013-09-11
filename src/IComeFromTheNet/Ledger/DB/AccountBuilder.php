<?php
namespace IComeFromTheNet\Ledger\DB;

use DBALGateway\Builder\BuilderInterface;
use IComeFromTheNet\Ledger\Entity\Account;

/**
  *  Builds an Account Entity
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class AccountBuilder
{
    
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
        
        $account->setGroupId($data['group_id']);
        $account->setAccountNumber($data['account_number']);
        $account->setAccountName($data['account_name']);
        $account->setDateOpened($data['account_date_opened']);
        $account->setDateClosed($data['account_date_closed']);
        
        
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
        return array(
                'account_number'      => $entity->getAccountNumber(),
                'account_name'        => $entity->getAccountName(),
                'account_date_opened' => $entity->getDateOpened(),
                'account_date_closed' => $entity->getDateClosed(),
                'group_id'            => $entity->getGroupId()
            );
    }
    
    
}
/* End of Class */
