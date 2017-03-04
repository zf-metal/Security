<?php

namespace ZfMetal\Security\Helper\View;

use Zend\View\Helper\AbstractHelper;

class GetModuleOptions extends AbstractHelper {

    /**
     *
     * @var \ZfMetal\Security\Options\ModuleOptions
     */
    private $moduleOptions;

    function __construct(\ZfMetal\Security\Options\ModuleOptions $moduleOptions) {
        $this->moduleOptions = $moduleOptions;
    }

    public function __invoke() {
        return $this->moduleOptions;
    }

}
