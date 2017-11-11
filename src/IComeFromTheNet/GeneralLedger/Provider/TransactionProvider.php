<?php 
namespace IComeFromTheNet\GeneralLedger\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Doctrine\DBAL\Schema\Schema;
use DBALGateway\Table\GatewayProxyCollection;


use IComeFromTheNet\GeneralLedger\Exception\LedgerException;
use IComeFromTheNet\GeneralLedger\Entity\CommonBuilder;
use IComeFromTheNet\GeneralLedger\Gateway\CommonGateway;

use IComeFromTheNet\GeneralLedger\Step\AggAllStep;
use IComeFromTheNet\GeneralLedger\Step\AggOrgUnitStep;
use IComeFromTheNet\GeneralLedger\Step\AggUserStep;

use IComeFromTheNet\GeneralLedger\TransactionDBDecorator;
use IComeFromTheNet\GeneralLedger\TransactionStepsDecorator;
use IComeFromTheNet\GeneralLedger\TransactionProcessor;


/**
 * Will bootstrap the transaction service
 * 
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */ 
class TransactionProvider implements ServiceProviderInterface
{
    
     
    
     
     
     public function __construct()
     {
        
         
     }
     
     
     public function register(Container $pimple, array $values = [])
     {
       
        
        $pimple['transaction_steps_user'] = function($c) {
            $oLogger   = $c->getAppLogger();
            $oDatabase = $c->getDatabaseAdapter();
            $aTableMap = $c->getTableMap();
            
            return new AggUserStep($oLogger,$oDatabase,$aTableMap);
            
        };
        
        $pimple['transaction_steps_org'] = function($c) {
            $oLogger   = $c->getAppLogger();
            $oDatabase = $c->getDatabaseAdapter();
            $aTableMap = $c->getTableMap();
            
            return new AggOrgUnitStep($oLogger,$oDatabase,$aTableMap);
            
        };
        
        $pimple['transaction_steps_all'] = function($c) {
            $oLogger   = $c->getAppLogger();
            $oDatabase = $c->getDatabaseAdapter();
            $aTableMap = $c->getTableMap();
            
            return new AggAllStep($oLogger,$oDatabase,$aTableMap);
            
        };
        
        
        $pimple['transaction_steps'] = function($c) {
            
            $aSteps = array(
               $c['transaction_steps_all']
              ,$c['transaction_steps_org']
              ,$c['transaction_steps_user']
            );
            
            return $aSteps;
            
        };
        
        $pimple['transaction_processor_core'] = function($c) {
            $oLogger   = $c->getAppLogger();
            $oDatabase = $c->getDatabaseAdapter();
            $aSteps    = $c['transaction_steps'];
            
            return new TransactionProcessor($oDatabase,$oLogger);
      
        };
        
        $pimple['transaction_processor_steps'] = function($c) {
             $aSteps    = $c['transaction_steps'];
           
             return new TransactionStepsDecorator($c['transaction_processor_core'],$aSteps);
            
        };
         
        $pimple['transaction_processor'] = function($c) {
            $oLogger   = $c->getAppLogger();
            $oDatabase = $c->getDatabaseAdapter();
            $aTableMap = $c->getTableMap();
            
            return new TransactionDBDecorator($c['transaction_processor_steps']);
             
        };
       
     
     }
     
     
    public function boot(Container $pimple)
    {
       
    }
    
    
}
/* End of Class */