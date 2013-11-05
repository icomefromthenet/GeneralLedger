<?php
namespace IComeFromTheNet\Ledger\Voucher\Driver;

use IComeFromTheNet\Ledger\Voucher\SequenceInterface;

/**
  *  A class that generate a sequence on a given platform
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
interface SequenceDriverInterface extends SequenceInterface
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
    
}
/* End of Interface */
