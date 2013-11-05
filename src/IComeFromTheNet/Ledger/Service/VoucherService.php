<?php
namespace IComeFromTheNet\Ledger\Service;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Doctrine\DBAL\Connection;
use IComeFromTheNet\Ledger\UnitOfWork;
use IComeFromTheNet\Ledger\Voucher\ValidationRuleBag;
use IComeFromTheNet\Ledger\Entity\VoucherType;
use IComeFromTheNet\Ledger\Voucher\VoucherUpdate;
use IComeFromTheNet\Ledger\Exception\LedgerException;

/**
  *  Service to manage and validate vouchers.
  *
  *  Ledger Transaction can often be classfied into
  *  discrete groups like:
  *
  *  1. Invoices
  *  2. General Journals
  *  3. Sales Recepits
  *  4. etc...
  *
  *  This service allows the definition of custom voucher types.
  *
  *  Ledger Transaction often result from activites, vouchers
  *  are a system to have categories for these activites and
  *  provide unique identifiers for each activity.
  *
  *  A Voucher has a unique identifer called a voucher reference
  *  which can be validated using rules registered with the ValidationRuleBag.
  *
  *  This service hide the temporal nature of the entity.
  *  Updating an entity requires closing current entity and
  *  change it to reference new created entity.
  *
  *  Some fields like description do not require a temporal update
  *  and will just update the current voucher type.
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class VoucherService extends UnitOfWork
{
    /*
     * @var IComeFromTheNet\Ledger\Voucher\ValidationRuleBag
     */
    protected $ruleBag;
    
    /*
     * @var DateTime the processing date
     */
    protected $processingDate;

    /*
     * @var Doctrine\DBAL\Connection
     */
    protected $dbal;
    
    /**
     *  @var Symfony\Component\EventDispatcher\EventDispatcherInterface
    */
    protected $eventDispatcher;
    
    /*
    * @var mixed array of voucherTypes to close
    */
    protected $closures = array();
    
    /*
    * @var mixed array of voucherTypes add
    */
    protected $additions = array();
    
    
    /**
     *  Class Constructor
     *
     *  @access public
     *  @return void
     *  @param EventDispatcherInterface $eventDispatcher
     *  @param Connection $dbal
     *  @param ValidationRuleBag $ruleBag
     *  @param DateTime $processingDate
     *
    */
    public function __construct(EventDispatcherInterface $eventDispatcher,
                                Connection $dbal,
                                ValidationRuleBag $ruleBag,
                                DateTime $processingDate)
    {
        
        $this->eventDispatcher = $eventDispatcher;
        $this->ruleBag         = $ruleBag;
        $this->processingDate  = $processingDate;
        $this->dbal            = $dbal;
    }
    
    
    //-------------------------------------------------------
    # CRUD Services
    
    /**
     *  Add a new Voucher Type.
     *
     *  Assign database id to the entity if sucessful
     *
     *  @access public
     *  @return $this;
     *
    */
    public function addVoucher(VoucherType $voucherType)
    {
        # check if been assigned a DB ID already
        $id = $voucherType->getVoucherTypeID();
        if(!empty($id)) {
            throw new LedgerException(sprintf('Voucher Type %s already exists can not be added'),$voucherType->getSlug());
        }
        
        # check if this voucher exists but for a different
        
        
        
        # validity date range
        
        
        
        # If exists does this new record overlap? (throw exception)
        
        $this->additions[$voucherType->getSlug()] = $voucherType;
        
        return $this;
    }
    
    
    /**
     *  Close a Voucher Type by setting validity date to the
     *  supplied value in the object or a max date
     *
     *  @access public
     *  @return boolean true if successful
     *  @param VoucherType $voucherType
     *
    */
    public function closeVoucher(VoucherType $voucherType)
    {
        if($voucherType->getEnabledTo() === null) {
            $max = new DateTime();
            $max->setDate(3000,1,1);
            $max->setTime(0,0,0);
            $voucherType->setEnabledTo($max);
        }
        
        return $this->closures[$voucherType->getSlug()] = $voucherType;
    }
    
    /**
     *  This will allow the voucher type to be updated with new
     *  values, to ensure consistency the current object will be
     *  loaded to provide the base.
     *
     *  A facade VoucherUpdate provides the interface, the
     *  service store single update an clear when committed 
     *
     *  @access public
     *  @return void
     *
    */
    public function updateVoucher($voucherSlugName)
    {
        # load most current voucher
        $v = '';        
        
        # closes the voucher
        
        
        
        
        # return update facade to user
        return VoucherUpdate($this->processingDate,$v,$this);
    }
    
    /**
     *  Load the voucher Repositry for a
     *  voucher lookup
     *
     *  @access public
     *  @return void
     *
    */
    public function voucherReposiory()
    {
        
    }
    
    //-------------------------------------------------------
    # Voucher Validation 
    
    /**
     *  docs
     *
     *  @access public
     *  @return void
     *
    */
    public function getValidationRuleBag()
    {
        return $this->ruleBag;
    }
    
    
    //-------------------------------------------------------
    # UnitOfWork
    
     /**
     *  Return the database connection  
     *
     *  @access public
     *  @return  Doctrine\DBAL\Connection
     *
    */
    public function getDBAL()
    {
        return $this->dbal;
    }
    
    
    //---------------------------------------------------------------------
    # API Methods to control Database Transaction

    
    /**
     *  Start this unit of work
     *
     *  @access protected
     *  @return void
     *
    */
    protected function start()
    {
        $this->dbal->beginTransaction();
    }
    
    
    /**
     *  Commit the result of the Unit of work
     *
     *  @access protected
     *  @return void
     *
    */
    protected function commit()
    {
        $this->dbal->commit();
    }
    
     /**
     *  Cause a rollback of this Unit of Work
     *
     *  @access public
     *  @return void
     *
    */
    protected function rollback()
    {
        $this->dbal->commit();
    }
    
    /**
     *  Does all updates, additions and closures
     *
     *  @access public
     *  @return void
     *
    */
    public function process()
    {
        
        try {
            $this->start();
            
            # execute all closures
        
        
            # execute all addition      
            
            
            $this->commit();    
            
        } catch(LedgerException $e) {
            $this->rollback();
            throw $e;
        } catch (Exception $e) {
            $this->rollback();
            throw new LedgerException($e);
        }
        
        # reset internal obejct closures
        $this->additions = array();
        $this->closures  = array();
            
    }
    
    
}
/* End of Class */
