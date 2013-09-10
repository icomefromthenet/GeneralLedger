<?php
namespace IComeFromTheNet\Ledger\Builder;

use DateTime;
use Doctrine\DBAL\Connection;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use IComeFromTheNet\Ledger\Service\AccountManagerService;
use IComeFromTheNet\Ledger\Builder\AccountGroupNode;
use IComeFromTheNet\Ledger\UnitOfWork;
use IComeFromTheNet\Ledger\Exception\LedgerException;
use IComeFromTheNet\Ledger\Event\Unit\UnitWorkEvent;
use IComeFromTheNet\Ledger\Event\Unit\UnitEvents;

/**
  *  Unit of work that install account groups
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class AccountGroupInstaller extends UnitOfWork
{
    /*
     * @var Doctrine\DBAL\Connection
     */
    protected $dbal;
    
    /*
     * @var IComeFromTheNet\Ledger\Builder\AccountGroupNode
     */
    protected $nodeTree;
    
    /*
     * @var IComeFromTheNet\Ledger\Service\AccountManagerService
     */
    protected $accountManager;
    
    /*
     * @var Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    protected $eventDispatcher;
    
    public function __construct(AccountGroupNode $nodeTree,
                                Connection $dbal,
                                AccountManagerService $accountManager,
                                EventDispatcherInterface $eventDispatcher
                                )
    {
        $this->dbal           = $dbal;
        $this->nodeTree       = $nodeTree;
        $this->accountManager = $accountManager;
        $this->eventDispatcher= $eventDispatcher;
    }
    
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
    
    
    /**
     *  Start this unit of work
     *
     *  @access protected
     *  @return void
     *
    */
    protected function start()
    {
       $this->getDBAL()->beginTransaction();
       
       $this->eventDispatcher->dispatch(UnitEvents::EVENT_START,new UnitWorkEvent($this));
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
        $this->getDBAL()->commit();
        
        $this->eventDispatcher->dispatch(UnitEvents::EVENT_COMMITTED,new UnitWorkEvent($this));
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
        $this->getDBAL()->rollBack();
        
        $this->eventDispatcher->dispatch(UnitEvents::EVENT_ROLLBACK,new UnitWorkEvent($this));
    }
    
    /**
     *  Save a group with a parent in recursive manner to gather all descendants
     *
     *  @access public
     *  @return void
     *  @param AccountGroupNode $node
     *  @param AccountGroupNode $parentNode
     *  @param AccountManager $mgr
     *
    */
    protected function recursiveSave(NodeInterface $node, NodeInterface $parentNode,AccountManagerService $mgr)
    {
        # assign parent node group database ID to the child
        $node->assignGroupID($parentNode->getGroupID());
        
        
        if($node instanceof AccountNode) {
            # add the account
            $mgr->open($node->getInternal());
        } else {
            # add the group
            $mgr->addGroup($node->getInternal());    
        }
        
        
        if($node->hasChildren()) {
            foreach($node->getChildren() as $child) {
                $this->recursiveSave($child,$node,$mgr);
            }
        }
        
    }
    
    
    /**
     *  Process the unit of work
     *
     *  @access public
     *  @return void
     *
    */
    public function process()
    {
        try {
            $this->start();
            
            $this->eventDispatcher->dispatch(UnitEvents::EVENT_PROCESSING_START,new UnitWorkEvent($this));
            
            # create root group
            $this->accountManager->addGroup($this->nodeTree->getInternal());
            
            
            
            # iterate over children call recursive save to gather descendants
            foreach($this->nodeTree->getChildren() as $child) {
                $this->recursiveSave($child,$this->nodeTree,$this->accountManager);
            }
            
            $this->eventDispatcher->dispatch(UnitEvents::EVENT_PROCESSING_FINISH,new UnitWorkEvent($this));
            
            $this->commit();
            
        } catch(LedgerException $e) {
            
            $this->eventDispatcher->dispatch(UnitEvents::EVENT_PROCESSING_ERROR,new UnitWorkEvent($this,$e));
            $this->rollback();
            throw $e;
        
        } catch(\Exception $e) {
        
            $this->eventDispatcher->dispatch(UnitEvents::EVENT_PROCESSING_ERROR,new UnitWorkEvent($this,$e));
            $this->rollback();
            throw new LedgerException($e->getMessage(),0,$e);
        
        }
    }
    
}
/* End of Class */
