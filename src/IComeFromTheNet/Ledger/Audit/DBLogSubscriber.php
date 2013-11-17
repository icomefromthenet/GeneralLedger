<?php
namespace IComeFromTheNet\Ledger\Audit;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
  *  Subscriber to handle events that need to be logged to database.
  *
  *  @author Lewis Dyer <getintouch@icomefromthenet.com>
  *  @since 1.0.0
  */
class DBLogSubscriber implements EventSubscriberInterface
{
    
    
    public static function getSubscribedEvents()
    {
        return array(
            'kernel.response' => array(
                array('onKernelResponsePre', 10),
                array('onKernelResponseMid', 5),
                array('onKernelResponsePost', 0),
            ),
            'store.order'     => array('onStoreOrder', 0),
        );
    }
    
    
    
    
    
    
    
}
/* End of Class */
