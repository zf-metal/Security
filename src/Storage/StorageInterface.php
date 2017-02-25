<?php

namespace ZfMetal\Security\Storage;

interface StorageInterface
{
    public function isEmpty($name);

    public function read($name);

    public function write($name, $value);

    public function clear($name);

}