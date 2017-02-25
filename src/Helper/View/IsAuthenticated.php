<?php

namespace ZfMetal\Security\Helper\View;

use Zend\View\Helper\AbstractHelper;

class IsAuthenticated extends AbstractHelper {

    /**
     *
     * @var \Zend\Authentication\AuthenticationService
     */
    private $authorize;

    function __construct(\Zend\Authentication\AuthenticationService $authorize) {
        $this->authorize = $authorize;
    }

    public function __invoke() {
        return ($this->authorize->hasIdentity()) ? $this->authorize->getIdentity() : false;
    }

}
