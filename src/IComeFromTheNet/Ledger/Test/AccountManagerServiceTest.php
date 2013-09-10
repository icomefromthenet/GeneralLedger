<?php
namespace IComeFromTheNet\Ledger\Test;

use DateTime;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use IComeFromTheNet\Ledger\Test\Base\TestWithFixture;
use IComeFromTheNet\Ledger\Service\AccountManagerService;


/**
  *  Unit test of the Account Manager
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class AccountManagerServiceTest extends TestWithFixture
{
    
    
    public function getDataSet()
    {
        return $this->createXMLDataSet(__DIR__ . DIRECTORY_SEPARATOR . 'Fixture'. DIRECTORY_SEPARATOR .'account_manager_service.xml');
    }

    
    public function testExample()
    {
        
    }
   
    
}
/* End of Class */