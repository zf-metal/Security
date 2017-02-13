<?php

namespace ZfMetal\Security\Session;

interface SessionInterface
{
    public function isEmpty($name);

    public function read($name);

    public function write($name, $value);

    public function clear($name);

}