<?php
namespace IComeFromTheNet\Ledger\Voucher\Driver;

use IComeFromTheNet\Ledger\Voucher\SequenceInterface;

/**
  *  A class that generate a sequence on a given platform
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
interface SequenceDriverInterface 
{
    
    /**
     *  SQL Vendor Platform
     *
     *  oracle|mysql|pgsql|mssql|sqlite|dbase ... etc
     *
     *  @access public
     *  @return string the sql vendor platform abbr
     *
    */
    public function getPlatform();
    
     /*
     * Generate a unique UUID from database
     *
     * @access public
     * @return integer|string a sequence value
     * @param string $sequenceName the sequence name
     *
     */
    public function uuid($name);
    
    /*
     * Generate a uniqe incrementing number
     *
     * @access public
     * @return integer|string a sequence value
     * @param string $sequenceName the sequence name
     *
     */
    public function sequence($name);
    
    
}
/* End of Interface */
