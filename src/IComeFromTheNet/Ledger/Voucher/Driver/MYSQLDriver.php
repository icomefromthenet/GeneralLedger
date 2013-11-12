<?php
namespace IComeFromTheNet\Ledger\Voucher\Driver;

use Doctrine\DBAL\Connection;
use IComeFromTheNet\Ledger\Exception\LedgerException;

/**
  *  Driver for the mysql plaform. will generate sequences
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class MYSQLDriver implements SequenceDriverInterface
{
    
    
    
    /**
     *  @var Doctrine\DBAL\Connection the database connection
    */
    protected $dbal;
    
    /**
     *  @var boolean true if sequence table found
    */
    protected $sequenceTableFound;
    
    /*
     * @var string the sequence table name
     */
    protected $sequenceTableName;
    
    /**
     *  Test if a Sequence Exists
     *
     *  @access public
     *  @return void
     *
    */
    protected function doesSequenceExist($sequenceName)
    {
        
    }
    
    /**
     *  Class Constructor
     *
     *  @access public
     *  @return void
     *
    */
    public function __construct(Connection $dbal,$sequenceTableName)
    {
        $this->dbal               = $dbal;
        $this->sequenceTableFound = false;
        
        if(empty($sequenceTableName)) {
           throw new LedgerException(sprinf("The sequence table name is empty string"));
        }
        
        $this->sequenceTableName = $sequenceTableName;
    }
    
    
   //-------------------------------------------------------
   # SequenceDriverInterface
    
    public function getPlatform()
    {
        return 'mysql';
    }
    
    
    //-------------------------------------------------------
    # SequenceInterface
    
   
    public function nextVal($sequenceName)
    {
        # is the sequence table found
        
        # lock sequence with select for update
        
        # update row
        
        # fetch auto-increment from driver
        
        //return $thi->dbal->
    }
    
 
    
}
/* End of Class */
