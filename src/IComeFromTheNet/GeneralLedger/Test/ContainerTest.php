<?php
namespace IComeFromTheNet\GeneralLedger\Test;

use IComeFromTheNet\GeneralLedger\Test\Base\ArrayDataSet;
use IComeFromTheNet\GeneralLedger\Test\Base\TestWithContainer;


class ContainerTest extends TestWithContainer
{
   
    public function getDataSet($fixtures = array()) 
    {
       return new ArrayDataSet([
           __DIR__.'/fixture/example-system.php',
        ]);
    }
    
    
    public function testContainerDBGateways()
    {
        $oContainer = $this->getContainer();
        
        $oGateway = $oContainer->getGatewayCollection()->getGateway('ledger_account');
        $this->assertInstanceOf('IComeFromTheNet\\GeneralLedger\\Gateway\\CommonGateway',$oGateway);
        
        $oGateway = $oContainer->getGatewayCollection()->getGateway('ledger_account_group');
        $this->assertInstanceOf('IComeFromTheNet\\GeneralLedger\\Gateway\\CommonGateway',$oGateway);
        
        $oGateway = $oContainer->getGatewayCollection()->getGateway('ledger_org_unit');
        $this->assertInstanceOf('IComeFromTheNet\\GeneralLedger\\Gateway\\CommonGateway',$oGateway);
        
        $oGateway = $oContainer->getGatewayCollection()->getGateway('ledger_org_unit');
        $this->assertInstanceOf('IComeFromTheNet\\GeneralLedger\\Gateway\\CommonGateway',$oGateway);
       
        $oGateway = $oContainer->getGatewayCollection()->getGateway('ledger_user');
        $this->assertInstanceOf('IComeFromTheNet\\GeneralLedger\\Gateway\\CommonGateway',$oGateway);
       
        $oGateway = $oContainer->getGatewayCollection()->getGateway('ledger_journal_type');
        $this->assertInstanceOf('IComeFromTheNet\\GeneralLedger\\Gateway\\CommonGateway',$oGateway);
       
        $oGateway = $oContainer->getGatewayCollection()->getGateway('ledger_transaction');
        $this->assertInstanceOf('IComeFromTheNet\\GeneralLedger\\Gateway\\CommonGateway',$oGateway);
       
        $oGateway = $oContainer->getGatewayCollection()->getGateway('ledger_entry');
        $this->assertInstanceOf('IComeFromTheNet\\GeneralLedger\\Gateway\\CommonGateway',$oGateway);
       
        $oGateway = $oContainer->getGatewayCollection()->getGateway('ledger_daily');
        $this->assertInstanceOf('IComeFromTheNet\\GeneralLedger\\Gateway\\CommonGateway',$oGateway);
       
        $oGateway = $oContainer->getGatewayCollection()->getGateway('ledger_daily_org');
        $this->assertInstanceOf('IComeFromTheNet\\GeneralLedger\\Gateway\\CommonGateway',$oGateway);
       
        $oGateway = $oContainer->getGatewayCollection()->getGateway('ledger_daily_user');
        $this->assertInstanceOf('IComeFromTheNet\\GeneralLedger\\Gateway\\CommonGateway',$oGateway);
       
    }
    
    
    
}
/* End of class */