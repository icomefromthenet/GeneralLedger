<?php
namespace IComeFromTheNet\GeneralLedger;

/**
  *  Abstract for unit of work, a transaction guard
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
interface UnitOfWork
{
   
    //---------------------------------------------------------------------
    # API Methods to control Database Transaction

    
    /**
     *  Start this unit of work
     *
     *  @access protected
     *  @return void
     *
    */
    public function start();
    
    
    /**
     *  Commit the result of the Unit of work
     *
     *  @access protected
     *  @return void
     *
    */
    public function commit();
    
     /**
     *  Cause a rollback of this Unit of Work
     *
     *  @access public
     *  @return void
     *
    */
    public function rollback();
    
}
/* End of Class */
