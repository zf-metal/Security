<?php

namespace ZfMetal\Security\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Crypt\Password\Bcrypt;

class BcryptEncoder extends AbstractPlugin{
    
    /**
     *
     * @var \Zend\Crypt\Password\Bcrypt
     */
    private $bcrypt;
    function getBcrypt() {
        return $this->bcrypt;
    }

    function __construct() {
        $this->bcrypt = new Bcrypt();
        $this->bcrypt->setCost(12);
    }

    
    public function encode($string){
        if(!is_string($string)){
            throw new Exception('La variable no es un String');
        }
        return $this->getBcrypt()->create($string);
    }
    
    public function verify($string1, $string2){
        if(!is_string($string1)||!is_string($string2)){
            throw new Exception('La variable no es un String');
        }
        return $this->getBcrypt()->verify($string1, $string2);
    }
    
}
