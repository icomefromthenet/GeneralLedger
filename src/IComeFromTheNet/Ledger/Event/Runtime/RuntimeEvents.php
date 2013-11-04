<?php
namespace IComeFromTheNet\Ledger\Event\Runtime;

/**
  *  List of events that occur during Ledger Load by the Runtime
  *  
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
final class RuntimeEvents
{
    /**
     * The ledger.runtime.before.boot event is raised each time a ledger is booted
     *
     * this event mya be used to modify the ledger before booting
     *
     * @var string
     */
    const EVENT_RUNTIME_BEFORE_BOOT = 'ledger.runtime.before.boot';
    
    /**
     * The ledger.runtime.after.boot event is raised after ledger is booted
     *
     * this event may be used to modify after booted 
     *
     * @var string
     */
    const EVENT_RUNTIME_AFTER_BOOT = 'ledger.runtime.after.boot';
    
    /**
     * The ledger.runtime.loadfailed event is raised when exception occurs
     * prevent a ledger for loading sucessfuly
     *
     * @var string
     */
    const EVENT_RUNTIME_LOAD_FAILED = 'ledger.runtime.loadfailed';
    
    
    
    
}
/* End of Class */