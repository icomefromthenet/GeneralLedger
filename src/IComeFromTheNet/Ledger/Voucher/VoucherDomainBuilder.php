<?php
namespace IComeFromTheNet\Ledger\Voucher;

use DBALGateway\Builder\BuilderInterface;
use IComeFromTheNet\Ledger\Voucher\VoucherEntity;
use Aura\Marshal\Type\GenericType;

/**
  *  Given to a gateway as a proxy between the Aura Marshal Domain Manager
  *  and the voucher entity builder.
  * 
  *  The Gateway when forfilling a domin lookup will be given
  *  this builder, where normally a builder will return a constructed
  *  entity this builder will instead add the data to the Identity
  *  map provider by aura.
  * 
  *  The Identity map will construct the voucher entity using
  *  the normal builder and tha will be returned.
  * 
  *  This builder does not impelement the Aura Builder Interface
  *  but only the gateway builder interface.
  * 
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class VoucherBuilder implements BuilderInterface
{
    
    /**
    * @var Aura\Marshal\Type\GenericType the IdentityMap
    */
    protected $identityMap;
    
    
    public function __construct(GenericType $map)
    {
        $this->identityMap = $map;
    }
    
    
    /**
      *  Convert data array into entity
      *
      *  @return Account
      *  @param array $data
      *  @access public
      */
    public function build($data)
    {
        return $this->identityMap->loadEntity($data);
    }
    
    /**
      *  Convert and entity into a data array
      *
      *  @return array
      *  @access public
      */
    public function demolish($entity)
    {
       
    }
    
    
}
/* End of Class */
