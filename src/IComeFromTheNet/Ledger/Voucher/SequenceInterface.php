<?php
namespace IComeFromTheNet\Ledger\Voucher;

/**
  *  All Class that generate a sequence which is an autoincrementing value 
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
interface SequenceInterface
{
    /*
     * Generate a value from autoincrement column
     *
     * @access public
     * @return integer
     * @param string $sequenceName the sequence name
     *
     */
    public function nextVal($sequenceName);
    
    /**
     *  Creates a new sequence
     *
     *  @access public
     *  @return true if sequence added
     *  @param string $sequenceName sequence name
     *  @param integer $start the start value
     *
    */
    public function addSequence($sequenceName,$start = 0);
    
    
    /**
     *  Remove an existing sequence
     *
     *  @access public
     *  @return true if removed
     *  @param string $sequenceName
     *
    */
    public function removeSequence($sequenceName);
    
}
/* End of Interface */