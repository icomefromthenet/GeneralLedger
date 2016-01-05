<?php
namespace IComeFromTheNet\GeneralLedger\Entity;

use DBALGateway\Query\AbstractQuery;
use DateTime;

/**
 * Builds Queries
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0
 */
class CommonQuery extends AbstractQuery
{

   
    
    /**
     *  Filter for entities that are enabled before but not including the given date
     * 
     * @param integer $id   The Voucher PK
     * @return CommonQuery
     */
    public function filterByEnabledBefore(DateTime $oDate)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('enabled_from')->getType();
        
        
        return $this->andWhere($this->expr()->lt($sAlias."enabled_from",$this->createNamedParameter($oDate,$paramType)));
    }
    
    /**
     *  Filter for entities that are enabled before and on the given date
     * 
     * @param integer $id   The Voucher PK
     * @return CommonQuery
     */
    public function filterByEnabledBeforeAndOn(DateTime $oDate)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('enabled_from')->getType();
        
        
        return $this->andWhere($this->expr()->lte($sAlias."enabled_from",$this->createNamedParameter($oDate,$paramType)));
    }
    
     /**
     *  Filter for entities that are enabledafter but not including the given date
     * 
     * @param integer $id   The Voucher PK
     * @return CommonQuery
     */
    public function filterByEnabledAfter(DateTime $oDate)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('enabled_from')->getType();
        
        
        return $this->andWhere($this->expr()->gt($sAlias."enabled_from",$this->createNamedParameter($oDate,$paramType)));
    }
    
    /**
     *  Filter for entities that are enabled after and on the given date
     * 
     * @param integer $id   The Voucher PK
     * @return CommonQuery
     */
    public function filterByEnabledAfterAndOn(DateTime $oDate)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('enabled_from')->getType();
        
        
        return $this->andWhere($this->expr()->gte($sAlias."enabled_from",$this->createNamedParameter($oDate,$paramType)));
    }
   
    /**
     *  Filter for entities that are disabled before but not including the given date
     * 
     * @param integer $id   The Voucher PK
     * @return CommonQuery
     */
    public function filterByDisabledBefore(DateTime $oDate)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('enabled_to')->getType();
        
        
        return $this->andWhere($this->expr()->lt($sAlias."enabled_to",$this->createNamedParameter($oDate,$paramType)));
    }
    
    /**
     *  Filter for entities that are disabled before and on the given date
     * 
     * @param integer $id   The Voucher PK
     * @return CommonQuery
     */
    public function filterByDisabledBeforeAndOn(DateTime $oDate)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('enabled_to')->getType();
        
        
        return $this->andWhere($this->expr()->lte($sAlias."enabled_to",$this->createNamedParameter($oDate,$paramType)));
    }
    
    /**
     *  Filter for entities that are disabled after but not including given date
     * 
     * @param integer $id   The Voucher PK
     * @return CommonQuery
     */
    public function filterByDisabledAfter(DateTime $oDate)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('enabled_to')->getType();
        
        return $this->andWhere($this->expr()->gt($sAlias."enabled_to",$this->createNamedParameter($oDate,$paramType)));
    }
    
    /**
     *  Filter for entities that are disabled after and on the given date
     * 
     * @param integer $id   The Voucher PK
     * @return CommonQuery
     */
    public function filterByDisabledAfterAndOn(DateTime $oDate)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        $paramType = $oGateway->getMetaData()->getColumn('enabled_to')->getType();
        
        return $this->andWhere($this->expr()->gte($sAlias."enabled_to",$this->createNamedParameter($oDate,$paramType)));
    }
    
    /**
     *  Find only current (enabled) entities 
     * 
     * @param integer $id   The Voucher PK
     * @return CommonQuery
     */
    public function filterByCurrent(DateTime $oCurrent)
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        
        $paramType = $oGateway->getMetaData()->getColumn('enabled_to')->getType();
        
        
        return $this->andWhere($this->expr()->eq($sAlias."enabled_to",$this->createNamedParameter($oCurrent,$paramType)));
       
    }
    
    /**
     * Return if the eposide has a stop date the precedes the start date
     * this means we have an invalid range.
     * 
     * @return CommonQuery
     */ 
    public function whereStartDateProceedsStopDate()
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        return $this->andWhere($this->expr()->lte($sAlias."enabled_to", $sAlias.'enabled_from'));
    }
    
    /**
     * Require the enabled date to fall after NOW 
     * 
     * @return CommonQuery
     */ 
    public function whereEnabledAfterNow()
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        return $this->andWhere($this->expr()->gt($sAlias."enabled_to",$oGateway->getAdapater()
                                                                 ->getDatabasePlatform()
                                                                 ->getNowExpression()));
        
    }
    
    /**
     * Require the enabled date to fall ON or After NOW 
     * 
     * @return CommonQuery
     */ 
    public function whereEnabledAfterAndOnNow()
    {
        $oGateway = $this->getGateway();
        $sAlias   = $this->getDefaultAlias();
        if(false === empty($sAlias)) {
            $sAlias = $sAlias .'.';
        }
        
        return $this->andWhere($this->expr()->gte($sAlias."enabled_to",$oGateway->getAdapater()
                                                                 ->getDatabasePlatform()
                                                                 ->getNowExpression()));
        
    }

}
/* End of Class */

