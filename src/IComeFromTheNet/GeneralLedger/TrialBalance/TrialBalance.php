<?php

/**
 *  This class will produce a trail balance.
 * 
 *  Debit accounts belong on the left of the accounting equation
 *  Credit accounts belong on the right of the accounting equation
 *  Extened Accounting Equation:  Assets + Expenses = Equity + Liabilities + Income 
 *           
 *  Example Set of account Using Accounts developed by National Standard Chart of Accounts
 *  From http://www.coag.gov.au/node/63
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 7.4
 */ 
class TrialBalance
{
    
    const NODE_ASSETS_ID    = 1;
    const NODE_EXPENSE_ID   = 2;
    const NODE_EQUITY_ID    = 3;
    const NODE_LIABILITY_ID = 4;
    const NODE_INCOME_ID    = 5;
    
    /**
     * @var AccountTree;
     */ 
    protected $oAccountTree;
    
    /**
     * @var array (array('account_number','account_name','credit','debit'))
     */  
    protected $aAccountList;
    
    /**
     * This will create an account list that split the balances into debit or credit
     * column. 
     * 
     * @access protected
     * @return void
     */ 
    protected function conductTrialBalance()
    {
        $oAccountTree = $this->oAccountTree;
        
        # Process each root node
        
        
        
    }
    
    
    
    public function __construct(AccountTree $oAccountTree)
    {
        $this->oAccountTree = $oAccountTree;
        
        $this->conductTrialBalance();
        
    }
    
    //--------------------------------------------------------------------------
    # Access The values of the root level accounts in GL
    
    public function getAssets()
    {
        return $this->oAccountTree->getNodeById(self::NODE_ASSETS_ID)->getBalance();
    }
    
    public function getExpenses()
    {
        return $this->oAccountTree->getNodeById(self::NODE_EXPENSE_ID)->getBalance();
    }
    
    public function getOwnersEquity()
    {
        return $this->oAccountTree->getNodeById(self::NODE_EQUITY_ID)->getBalance();
    }
    
    public function getLiabilities()
    {
        return $this->oAccountTree->getNodeById(self::NODE_LIABILITY_ID)->getBalance();
    }
    
    public function getIncome()
    {
        return $this->oAccountTree->getNodeById(self::NODE_INCOME_ID)->getBalance();
    }
    
    //--------------------------------------------------------------------------
    # Get the balance of the left and right accounts
    
    
    public function getTrialBalance()
    {
        return $aAccountList;
    }
    
}
/* End of File */