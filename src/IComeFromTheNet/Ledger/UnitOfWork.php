<?php
namespace IComeFromTheNet\Ledger;

/**
  *  Abstract for unit of work, a transaction guard
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
abstract class UnitOfWork
{
    
     /**
     *  Return the database connection  
     *
     *  @access public
     *  @return  Doctrine\DBAL\Connection
     *
    */
    abstract public function getDBAL();
    
    
    //---------------------------------------------------------------------
    # API Methods to control Database Transaction

    
    /**
     *  Start this unit of work
     *
     *  @access protected
     *  @return void
     *
    */
    abstract protected function start();
    
    
    /**
     *  Commit the result of the Unit of work
     *
     *  @access protected
     *  @return void
     *
    */
    abstract protected function commit();
    
     /**
     *  Cause a rollback of this Unit of Work
     *
     *  @access public
     *  @return void
     *
    */
    abstract protected function rollback();
    
     /**
     *  Process the unit of work
     *
     *  @access public
     *  @return void
     *
    */
    abstract public function process();
}
/* End of Class */
