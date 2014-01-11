<?php
namespace IComeFromTheNet\Ledger\Voucher\Formatter;

use ArrayIterator;
use IComeFromTheNet\Ledger\Exception\LedgerException;

/**
  *  A Bag to contain instanced formatters.
  *
  *  A formatter combines the sequence with a prefix and suffix
  *  with optional length and any other params defined at runtime
  *  to produce a voucher reference
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class FormatterBag implements FormatterBagInterface
{
    
    protected $formatters = array();
    
    
    /**
     *  Adds a formatter if not set
     *
     *  @access public
     *  @return void
     *  @param string $name the reference name
     *  @param FormatBagInterface $f the instanced formatter
     *
    */
    public function addFormatter($name,FormatterInterface $f)
    {
        if(isset($this->formatters[$name])) {
            throw new LedgerException("$name already been added to the Formatter Bag");
        }
        
        $this->formatters[$name] = $f;
    }
    
    /**
     *  Return a formatter at name
     *
     *  @access public
     *  @return FormatterInterface|null the assigned formatter
     *  @param string $name
    */
    public function getFormatter($name)
    {
        $formatter = null;
        if(isset($this->formatters[$name])) {
            $rule = $this->formatters[$name];
        }
        
        return $$formatter;
    }
    
    /**
     *  Remove an assigned formatter
     *
     *  @access public
     *  @return boolean true if removed
     *  @param string $name
     *
    */
    public function removeFormatter($name)
    {
        $removed = false;
        
        if($this->existsFormatter($name)) {
            unset($this->formatters[$name]);
            $removed = true;
        }

        return $removed;
    }
    
    /**
     *  Check the formatter has been added
     *
     *  @access public
     *  @return boolean true if exists internally
     *  @param string $name
     *
    */
    public function existsFormatter($name)
    {
        return isset($this->formatters[$name]);
    }
    
    
    
    //-------------------------------------------------------
    # IteratorAggregate Interface
    
    
    public function getIterator()
    {
        return new \ArrayIterator($this->formatters);
    }
    
}
/* End of Class */
 