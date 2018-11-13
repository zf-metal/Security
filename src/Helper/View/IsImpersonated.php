<?php

namespace ZfMetal\Security\Helper\View;

use Zend\View\Helper\AbstractHelper;

class IsImpersonted extends AbstractHelper {

    /**
     *
     * @var \ZfMetal\Security\Services\Impersonate
     */
    private $impersonate;

    /**
     * IsImpersonted constructor.
     *
     * @param \ZfMetal\Security\Services\Impersonate $impersonate
     */
    public function __construct(\ZfMetal\Security\Services\Impersonate $impersonate)
    {
        $this->impersonate = $impersonate;
    }


    public function __invoke() {
        return $this->impersonate->isImpersonated();
    }

}
