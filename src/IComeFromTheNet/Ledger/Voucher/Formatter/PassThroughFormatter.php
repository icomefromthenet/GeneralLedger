<?php
namespace IComeFromTheNet\Ledger\Voucher\Formatter;

use Zend\Stdlib\StringWrapper\StringWrapperInterface;

/**
  *  Null Formatter will just return the sequence.
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class PassThroughFormatter implements FormatterInterface
{

   protected  $suffix;
   protected  $prefix;
   protected  $maxLength;
   protected  $paddingChar;
   
   /**
    * @var Zend\Stdlib\StringWrapper\StringWrapperInterface
   */
   protected $strWrapper;
   


    //-------------------------------------------------------
    # Formatter Interface

    public function getPrefix()
    {
        return $this->prefix;
    }
    
    public function getSuffix()
    {
        return $this->suffix;
    }
    
    public function getMaxLength()
    {
        return $this->maxLength;
    }
    
    public function getPadding()
    {
        return $this->paddingChar;
    }
    
    public function getStringWrapper()
    {
        return $this->strWrapper;
    }
    
    public function format($sequence)
    {
        return $sequence;
    }
    
    
    /**
     *  Name as referenced in the Voucher Bag
     *
     *  @access public
     *  @return string name
     *
    */
    public function getName()
    {
        return 'passthrough';
    }
    
    
}
/* End of Class */
