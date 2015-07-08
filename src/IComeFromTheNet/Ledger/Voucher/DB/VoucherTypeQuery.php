<?php
namespace IComeFromTheNet\Ledger\Voucher\DB;

use DateTime;
use DBALGateway\Query\AbstractQuery;
use DBALGateway\Query\QueryInterface;

/**
  *  Vouch Type Query Builder
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class VoucherTypeQuery extends AbstractQuery implements QueryInterface
{
    
    /**
     * Filter to slug with given name
     * 
     * @param string $slug the slug id field
     */ 
    public function filterBySlugKey($slug)
    {
        $this->where('account_number = :account_number')
             ->setParameter('account_number',
                            $accountNumber,
                            $this->getGateway()->getMetaData()->getColumn('account_number')->getType());
        return $this;
    }
    
    
    public function filterByEnabledOn(DateTime $enabled)
    {
        
        return $this;
    }
    
    
    public function filterByDisabledOn(DateTime $disabled)
    {
        
        
        return $this;
    }
   
   
    /**
     * Filter to voucher enabled between these dates 
     * 
     * @access public
     * @param DateTime $start
     * @param DateTime $finish
     */ 
    public function filterByEnabledBetween(DateTime $start, DateTime $finish)
    {
    
        return $this;
    }
    
    /**
     * Filter to vouchers where enabledFrom after date x
     * 
     * @access public
     * @param DateTime $after
     */ 
    public function filterByEnabledAfter(DateTime $after)
    {
            $this->where('voucher_enabled_from = :voucher_enabled_after')
             ->setParameter('voucher_enabled_after',
                            $after,
                            $this->getGateway()->getMetaData()->getColumn('voucher_enabled_from')->getType());

        return $this;
    
        
    }
    
    /**
     * Filter to vouchers where enabedTo before date x
     * 
     * @access public
     * @param DateTime $before
     */
    public function filterByEnabledBefore(DateTime $before)
    {
            $this->where('account_date_opened = :account_date_opened')
             ->setParameter('account_date_opened',
                            $opened,
                            $this->getGateway()->getMetaData()->getColumn('account_date_opened')->getType());

        return $this;
    
        
    }
    
    /**
     * Applies a Like query to the name column 
     * 
     * @access public
     * @param string $name the name part to search
     */
    public function filterLikeVoucherName($name)
    {
         $this->where($this->expr()->like('account_name','%:account_name%'))
            ->setParameter('account_name',
                           $name,
                           $this->getGateway()->getMetaData()->getColumn('account_name')->getType());
        
        return $this;    
    }
    
    
    
}
/* End of Class */
