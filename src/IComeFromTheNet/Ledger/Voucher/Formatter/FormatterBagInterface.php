<?php
namespace IComeFromTheNet\Ledger\Voucher\Formatter;

use IteratorAggregate;
use ArrayIterator;
use IComeFromTheNet\Ledger\Voucher\Formatter\FormatterInterface;

/**
  *  The bag for init formatters.
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
interface FormatterBagInterface extends IteratorAggregate
{
    
    /**
     *  Adds a formatter if not set
     *
     *  @access public
     *  @return void
     *  @param string $name the reference name
     *  @param FormatBagInterface $f the instanced formatter
     *
    */
    public function addFormatter($name,FormatterInterface $f);
    
    /**
     *  Return a formatter at name
     *
     *  @access public
     *  @return FormatterInterface|null the assigned formatter
     *  @param string $name
    */
    public function getFormatter($name);
    
    /**
     *  Remove an assigned formatter
     *
     *  @access public
     *  @return boolean true if removed
     *  @param string $name
     *
    */
    public function removeFormatter($name);
    
    /**
     *  Check the formatter has been added
     *
     *  @access public
     *  @return boolean true if exists internally
     *  @param string $name
     *
    */
    public function existsFormatter($name);
    
    
}
/* End of Interface */