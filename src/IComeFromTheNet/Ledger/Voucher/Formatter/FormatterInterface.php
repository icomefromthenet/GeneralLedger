<?php
namespace IComeFromTheNet\Ledger\Voucher\Formatter;

/**
  *  Format a voucher reference.
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
interface FormatterInterface
{
    
    /**
     *  Return the assigned prefix
     *
     *  @access public
     *  @return string the assigned prefix
     *
    */
    public function getPrefix();
    
    /**
     *  Return the assigned suffix
     *
     *  @access public
     *  @return string the assigned suffic
     *
    */
    public function getSuffix();
    
    /**
     *  Return the max length of format string
     *
     *  @access public
     *  @return integer the max length of voucher reference
     *
    */
    public function getMaxLength();
    
    /**
     *  Return the assigned padding character
     *
     *  @access public
     *  @return string the assigned padding character
     *
    */
    public function getPadding();
    
    /**
     *  Return the class that contains string functions
     *
     *  @access public
     *  @return Zend\Stdlib\StringWrapper\StringWrapperInterface
     *
    */
    public function getStringWrapper();
    
    
    
    /**
     *  Format a voucher reference.
     *
     *  @access public
     *  @return string the voucher reference
     *
    */
    public function format($sequence);
    
    
    /**
     *  Name as referenced in the Voucher Bag
     *
     *  @access public
     *  @return string name
     *
    */
    public function getName();
    
    
}
/* End of Interface */