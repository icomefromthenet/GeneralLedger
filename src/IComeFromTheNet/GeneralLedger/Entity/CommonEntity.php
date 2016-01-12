<?php
namespace IComeFromTheNet\GeneralLedger\Entity;

use DateTime;
use DBALGateway\Table\AbstractTable;
use Psr\Log\LoggerInterface;
use Valitron\Validator;


abstract class CommonEntity implements ActiveRecordInterface
{
    /**
     * @var array of validationrules
     */ 
    protected $aValidationRules;
    
    /**
     * @var DBALGateway\Table\AbstractTable
     */ 
    protected $oGateway;
    
    /**
     * @var Psr\Log\LoggerInterface
     */ 
    protected $oLogger;
    
    /**
     * @var array the last result query
     */ 
    protected $aLastResult;
    
    /*
    *   Taken from the PHP documentation website.
    *
    *   Kristof_Polleunis at yahoo dot com
    *
    *   A guid function that works in all php versions:
    *   MEM 3/30/2015 : Modified the function to allow someone
    *       to specify whether or not they want the curly
    *       braces on the GUID.
    *
    * @link http://php.net/manual/en/function.com-create-guid.php
    * @return string a guid
    * @access protected
    */    
    protected function guid($opt = true )
    {       
        
        //  Set to true/false as your default way to do this.
        if(true === function_exists('com_create_guid')){
            if( $opt ){ 
                return com_create_guid(); 
            }
            else { 
                return trim( com_create_guid(), '{}' ); 
            }
        }
        else {
            mt_srand( (double)microtime() * 10000 );    // optional for php 4.2.0 and up.
            $charid = strtoupper( md5(uniqid(rand(), true)) );
            $hyphen = chr( 45 );    // "-"
            $left_curly = $opt ? chr(123) : "";     //  "{"
            $right_curly = $opt ? chr(125) : "";    //  "}"
            $uuid = $left_curly
                . substr( $charid, 0, 8 ) . $hyphen
                . substr( $charid, 8, 4 ) . $hyphen
                . substr( $charid, 12, 4 ) . $hyphen
                . substr( $charid, 16, 4 ) . $hyphen
                . substr( $charid, 20, 12 )
                . $right_curly;
            return $uuid;
        }
        
    }
    
    /**
     *  Class Constructor
     * 
     *  @return void
     *  @access public
     */ 
    public function __construct(AbstractTable $oGateway, LoggerInterface $oLogger) 
    {
        $this->oGateway = $oGateway;
        $this->oLogger  = $oLogger;
        
    }
    
    /**
     * Return the assigned table gateway
     * 
     * @return DBALGateway\Table\AbstractTable
     */ 
    public function getTableGateway()
    {
        return $this->oGateway;
    }
    
    
    /**
     * Return the app logger
     * 
     * @return Psr\Log\LoggerInterface
     */ 
    public function getAppLogger()
    {
        return $this->oLogger;
    }
    
    /**
     * Fetch the last query result 
     * 
     * @return array('result' => '', 'msg' =>'')
     */ 
    public function getLastQueryResult()
    {
        return $this->aLastResult;
    }
    
    
    
    
    // -------------------------------------------------------------
    #  ActiveRecordInterface
    
    /**
     * Save an entity using the gateway and builder
     * 
     * Stores last result internally use self::getLastQueryResult().
     * 
     * Will capture all exceptions so you must check the result struct for a pass/fail.
     * 
     * @access public
     * @return boolean true if saved
     */ 
    public function save()
    {
        $oGateway = $this->getTableGateway();
        $oBuilder = $this->getTableGateway()->getEntityBuilder();
        $this->aLastResult = array('result' => false, 'msg' =>'');
    
        try {
        
            $aDatabaseData = $oBuilder->demolish($this);            
            $bResult       = false;
        
            if(true === $this->validate($aDatabaseData,$this->aValidators)) {
        
                if(true === empty($this->getEntityId())) {
                    $bResult = $this->createNew($aDatabaseData);
                } else {
                    $bResult = $this->updateExisting($aDatabaseData);
                }
                
            }
            
        }
        catch(\Exception $e) {
            $this->getAppLogger()->error($e->getMessage());
            $this->aLastResult['msg'] = $e->getMessage();
            $this->aLastResult['result'] = false;
        }
        
        return $bResult;
        
    }
    
    /**
     * Remove an entity using the gateway and builder
     * 
     * Stores last result internally use self::getLastQueryResult().
     * 
     * Will capture all exceptions so you must check the result struct for a pass/fail.
     * 
     * Must be a full object should load this entity from database and then delete
     * 
     * @access public
     * @return boolean true if removed
     */ 
    public function remove()
    {
        
        $oGateway = $this->getTableGateway();
        $oBuilder = $this->getTableGateway()->getEntityBuilder();
        $this->aLastResult = array('result' => false, 'msg' =>'');
        $bResult = false;
        
        try {
        
            $aDatabaseData = $oBuilder->demolish($this);            
            $bResult       = false;
        
            if(true === $this->validate($aDatabaseData,$this->aValidators)) {
        
                if(true === empty($this->getEntityId())) {
                    
                    $this->aLastResult['msg']    = 'Entity Requires an Id to before it can be removed';
                    $this->aLastResult['result'] = false;
                    
                } else {
                    $bResult = $this->deleteExisting($aDatabaseData);
                }
                
            }
            
        }
        catch(\Exception $e) {
            $this->getAppLogger()->error($e->getMessage());
            $this->aLastResult['msg']    = $e->getMessage();
            $this->aLastResult['result'] = false;
        }
        
        return $bResult;
    
            
    }
    
    
    
    //-----------------------------------------------------------------
    # Extra Validator Helpers
    
    /**
     * Validate an object using the data and rules passed in
     * 
     * Will update the last result with validation errors
     * 
     * @param array $aData   The data to validate 
     * @param array $aRules  The results to apply
     * 
     * @return boolean true if valid false otherwise
     */ 
    public function validate($aData,$aRules)
    {
        $oValidator = new Validator($aData);
        
        $oValidator->rules($aRules);
        
        $bValid = $oValidator->validate();
        
        if(false === $bValid) {
            $this->aLastResult['result'] = false;
            $this->aLastResult['msg'] = $oValidator->errors();
        }
        
        return $bValid;
        
    }
    
    
    
    //--------------------------------------------------------------------------
    # Database Hooks
    
    abstract protected function createNew($aDatabaseData);
    
    
    abstract protected function updateExisting($aDatabaseData);
    
    
    abstract protected function deleteExisting($aDatabaseData);
    
    
    abstract protected function getEntityId();
    
}
/* End of Class */