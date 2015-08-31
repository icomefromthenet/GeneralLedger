<?php
namespace IComeFromTheNet\Ledger\Test\Voucher;

use DateTime;
use Mrkrstphr\DbUnit\DataSet\ArrayDataSet;
use IComeFromTheNet\Ledger\Voucher\DB\VoucherGroup;
use IComeFromTheNet\Ledger\Voucher\DB\VoucherGroupBuilder;

class VoucherOperationsTest extends VoucherTestAbstract
{
    
    public function getDataSet()
    {
       return new ArrayDataSet([
           __DIR__.'/VoucherFixture.php',
        ]);
    }
    
    
    public function testVoucherGroupCreate()
    {
        
        $oContainer = $this->getContainer();
        
        
        
     
    }
    
    
    
}
/* End of class */