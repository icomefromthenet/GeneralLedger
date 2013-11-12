<?php
namespace IComeFromTheNet\Ledger\Voucher;

/**
  *  A sequence is an auto incrementing value. Database platforms implement
  *  their sequences in different ways. MYSQL uses autoincrement columns while
  *  Oracle uses named sequences.
  *
  *  When given a sequence name, a class that implements this interface
  *  should map that name to a value.
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
interface SequenceInterface
{
    /*
     * Generate an incrementing value
     *
     * @access public
     * @return integer|string a sequence value
     * @param string $sequenceName the sequence name
     *
     */
    public function nextVal($sequenceName);
    
    
}
/* End of Interface */