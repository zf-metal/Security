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
        $i = 0;
        $r = '';
        while ($i++ < $this->length) {
            $r .= chr(mt_rand(0, 255));
        }

        return substr(bin2hex($r), 0, $this->length);
    }
}
