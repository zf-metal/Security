<?php

namespace ZfMetal\Security\Options;

use Zend\Stdlib\AbstractOptions;

/**
 */
class ModuleOptions extends AbstractOptions
{
    /**
     * Enable Public Register 
     *
     * @var boolean
     */
    protected $publicRegister = true;
    
     /**
     * Enable Password Recovery 
     *
     * @var boolean
     */
    protected $passwordRecovery = true;


    /**
     * Constructor
     */
    public function __construct($options = null)
    {
        $this->__strictMode__ = false;
        parent::__construct($options);
    }
    
  
    function getPublicRegister() {
        return $this->publicRegister;
    }

    function setPublicRegister($publicRegister) {
        $this->publicRegister = $publicRegister;
    }

    function getPasswordRecovery() {
        return $this->passwordRecovery;
    }

    function setPasswordRecovery($passwordRecovery) {
        $this->passwordRecovery = $passwordRecovery;
    }





   
}
