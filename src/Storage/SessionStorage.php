<?php

namespace ZfMetal\Security\Storage;

use Zend\Session\Container as SessionContainer;

class SessionStorage implements StorageInterface
{

    /**
     * Object to proxy $_SESSION storage
     *
     * @var SessionContainer
     */
    protected $session;


    public function __construct($namespace = __CLASS__)
    {
        $this->session = new SessionContainer($namespace);
    }


    public function isEmpty($name)
    {
        return !isset($this->session->{$name});
    }


    public function read($name)
    {
        return $this->session->{$name};
    }

    public function write($name, $value)
    {
        $this->session->{$name} = $value;
    }

    public function clear($name)
    {
        unset($this->session->{$name});
    }
}