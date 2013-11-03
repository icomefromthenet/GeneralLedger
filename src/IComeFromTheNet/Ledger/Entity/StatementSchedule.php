<?php
namespace IComeFromTheNet\Ledger\Entity;

use Aura\Marshal\Entity\GenericEntity;


/**
  *  A schedule when to make a statement run
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class StatementSchedule extends GenericEntity
{
    
    const FIELD_STATEMENT_SCHEDULE_ID = 'statement_schedule_id';
    const FIELD_LAST_RUN              = 'last_run';
    const FIELD_LAST_ERROR            = 'last_error';
    const FIELD_RUN_UNIT              = 'run_unit';
    const FIELD_LAST_MSG              = 'last_msg';
    const FIELD_ENABLED_FROM          = 'enabled_from';
    const FIELD_ENABLED_TO            = 'enabled_to';
    
    
    public function __construct()
    {
        
        
    }
    
    
    public function getStatementScheduleID()
    {
        
    }
    
    
    public function setStatementScheduleID()
    {
        
    }
    
}
/* End of Class */

