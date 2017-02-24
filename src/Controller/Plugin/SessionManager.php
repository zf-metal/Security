<?php

namespace ZfMetal\Security\Controller\Plugin;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class SessionManager extends AbstractPlugin
{
    /**
     * @var \ZfMetal\Security\Session\SessionInterface
     */
    private $sessionContainer;

    /**
     * @return StorageSession
     */
    public function getSessionContainer()
    {
        return $this->sessionContainer;
    }

    /**
     * @param StorageSession $sessionContainer
     */
    public function setSessionContainer($sessionContainer)
    {
        $this->sessionContainer = $sessionContainer;
    }

    /**
     * SessionManager constructor.
     * @param StorageSession $sessionContainer
     */
    public function __construct(\ZfMetal\Security\Session\SessionInterface $sessionContainer)
    {
        $this->sessionContainer = $sessionContainer;
    }

    public function has($name){
        return !$this->getSessionContainer()->isEmpty($name)?True:False;
    }

    public function set($name, $value){
        $this->getSessionContainer()->write($name,$value);
        return $this->has($name);
    }

    public function get($name){
        $value = null;
        if($this->has($name)){
            $value = $this->getSessionContainer()->read($name);
        }
        return $value;
    }

    public function remove($name){
        $this->getSessionContainer()->clear($name);
        return !$this->has($name);
    }

    public function getFlash($name){
        $value = null;
        if($this->has($name)){
            $value = $this->get($name);
            $this->remove($name);
        }
        return $value;
    }
}