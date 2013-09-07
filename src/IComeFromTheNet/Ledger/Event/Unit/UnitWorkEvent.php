<?php
namespace IComeFromTheNet\Ledger\Event\Unit;

use Exception;
use Symfony\Component\EventDispatcher\Event;
use IComeFromTheNet\Ledger\UnitOfWork;

/**
  *  Event object for the Transactor ie a Unit of Work
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class UnitWorkEvent extends Event
{
    /*
     * @var IComeFromTheNet\Ledger\UnitOfWork the unit of work
     */
    protected $unit;
    
    protected $exception;
   
    public function __construct(UnitOfWork $unit, Exception $exception = null)
    {
        $this->unit      = $unit;
        $this->exception = $exception;
    }
    
    
    /**
     *  Return the Unit of Work
     *
     *  @access public
     *  @return IComeFromTheNet\Ledger\UnitOfWork
     *
    */
    public function getUnitOfWork()
    {
        return $this->unit;
    }
    
    /**
     *  Fetch the exception is assigned
     *
     *  @access public
     *  @return Exception
     *
    */
    public function getException()
    {
        return $this->exception;
    }
}
/* End of Class */



