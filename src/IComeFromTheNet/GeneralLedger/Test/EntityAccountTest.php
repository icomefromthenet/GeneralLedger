<?php
namespace IComeFromTheNet\GeneralLedger\Test;

use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use IComeFromTheNet\GeneralLedger\Test\Base\TestWithContainer;
use IComeFromTheNet\GeneralLedger\Entity\Account;


class EntityAccountTest extends TestWithContainer
{
   
    public function getDataSet()
    {
       return new ArrayDataSet([
           __DIR__.'/fixture/example-system.php',
        ]);
    }
    
    
    
    public function testEntitySave()
    {
        $oContainer = $this->getContainer();
        $oLogger    = $oContainer->getAppLogger();
        $oGateway   = $oContainer->getGatewayCollection()->getGateway('ledger_account');
        
       
        
    }
    
    
    
}
/* End of class */