<?php
namespace IComeFromTheNet\GeneralLedger\Gateway;

use DBALGateway\Query\AbstractQuery;
use DateTime;

/**
 * Builds Query for Points Systems
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class CommonQuery extends AbstractQuery
{

    /**
     * Filter out hidden entities
     * 
     * @return CommonQuery
     */ 
    public function filterOutHidden()
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('hide_ui')->getType();
        
        return $this->andWhere($this->expr()->eq($sAlias."hide_ui",$this->createNamedParameter(true,$paramType)));
        
    }
    
    
}
/* End of Class */

