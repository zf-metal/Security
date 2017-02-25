<?php

namespace ZfMetal\Security\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class StringGenerator extends AbstractPlugin
{
    /**
     * @var int
     */
    private $length = 10;

    public function generate()
    {
        switch (true) {
            case function_exists('mcrypt_create_iv') :
                $r = mcrypt_create_iv($this->length, MCRYPT_DEV_URANDOM);
                break;
            case function_exists('openssl_random_pseudo_bytes') :
                $r = openssl_random_pseudo_bytes($this->length);
                break;
            case is_readable('/dev/urandom') : // deceze
                $r = file_get_contents('/dev/urandom', false, null, 0, $this->length);
                break;
            default :
                $i = 0;
                $r = '';
                while ($i++ < $this->length) {
                    $r .= chr(mt_rand(0, 255));
                }
                break;
        }
        return substr(bin2hex($r), 0, $this->length);
    }
}
