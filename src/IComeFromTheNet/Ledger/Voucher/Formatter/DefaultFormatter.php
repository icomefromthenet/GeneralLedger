<?php
namespace IComeFromTheNet\Ledger\Voucher\Formatter;

use Zend\Stdlib\StringWrapper\StringWrapperInterface;

/**
  *  The default voucher reference formatter.
  *
  *  Will combine prefix with sequence and suffic and
  *  will padd/truncate the max line difference
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class DefaultFormatter implements FormatterInterface
{

   protected  $suffix;
   protected  $prefix;
   protected  $maxLength;
   protected  $paddingChar;
   
   /**
    * @var Zend\Stdlib\StringWrapper\StringWrapperInterface
   */
   protected $strWrapper;
   
   public function __construct(StringWrapperInterface $wrapper, $suffix,$prefix,$maxLength,$paddingChar = '#')
   {
     $this->strWrapper  = $wrapper;
     $this->suffix      = $suffix;
     $this->prefix      = $prefix;
     $this->maxLength   = $maxLength;
     $this->paddingChar = $paddingChar;
   }


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
        $ref     = $this->getPrefix() . $sequence . $this->getSuffix();
        $length  = $this->getMaxLength();
        
        
        if($length !== null) {
            
            $refLength = $this->getStringWrapper()->strlen($ref);
            
            if($refLength > $length) {
                $ref = $this->getStringWrapper()->substr($ref,0,($length -1));
            } else if($refLength < $length) {
                $ref = $this->getStringWrapper()->strPad($ref, ($length -1), $this->getPadding());
            } 
        }
        
        return $ref;
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
        return 'default';
    }
    
    
}
/* End of Class */
