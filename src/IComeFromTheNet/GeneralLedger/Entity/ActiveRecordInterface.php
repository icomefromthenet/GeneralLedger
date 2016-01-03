<?php
namespace IComeFromTheNet\GeneralLedger\Entity;

/**
  *  AR methods for basic CRUD 
  * 
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */ 
interface ActiveRecordInterface
{
    
    public function save();
    
    
    public function remove();
    
    
    public function validate($aData,$aRules);
    
}
/* End of Interface */