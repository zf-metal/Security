<?php

namespace ZfMetal\Security\Adapter;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Crypt\Password\Bcrypt;

class RememberMe implements AdapterInterface {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * 
     * @var string
     */
    private $token;

    function getToken() {
        return $this->token;
    }

    function setToken($token) {
        $this->token = $token;
    }

    function __construct(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    function getEm() {
        return $this->em;
    }

    /**
     * @param $em \Doctrine\ORM\EntityManager
     */
    function setEm(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }

    /**
     * Authenticate
     *
     * @return \Zend\Authentication\Result
     */
    public function authenticate() {

        $identity = $this->getEm()->getRepository('ZfMetal\Security\Entity\RememberMe')->getUserIdByToken($this->token);

        $mensaje = array();
        $code = 0;

        if ($identity) {
            //Forzamos la obtencion de Roles.
            $identity->getRoles()->getValues();
            if (!$identity->isActive()) {
                $mensaje = ['Falla al autenticar, usuario inactivo'];
            } else {
                $code = 1;
            }
        } else {
            $mensaje = ['Token Inválido.'];
        }

        return new \Zend\Authentication\Result($code, $identity, $mensaje);
    }

}
