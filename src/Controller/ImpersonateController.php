<?php

namespace ZfMetal\Security\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mail;
use Zend\Crypt\Password\Bcrypt;

class ImpersonateController extends AbstractActionController {

    /**
     * @var \ZfMetal\Security\Options\ModuleOptions
     */
    protected $moduleOptions;

    /**
     * @var \ZfMetal\Security\Services\Impersonate
     */
    protected $impersonateService;

    /**
     * ImpersonateController constructor.
     *
     * @param \ZfMetal\Security\Options\ModuleOptions $moduleOptions
     * @param \ZfMetal\Security\Services\Impersonate $impersonateService
     */
    public function __construct(\ZfMetal\Security\Options\ModuleOptions $moduleOptions, \ZfMetal\Security\Services\Impersonate $impersonateService)
    {
        $this->moduleOptions = $moduleOptions;
        $this->impersonateService = $impersonateService;
    }


    function getImpersonateService() {
        return $this->impersonateService;
    }
    
    function getModuleOptions() {
        return $this->moduleOptions;
    }


    public function impersonateAction() {
        // Start impersonating the user specified by the user id route parameter specified in config.
        $this->getImpersonateService()->impersonate($this->params()->fromRoute('userId'));

        // Redirect to the post impersonation redirect route, if specified in config.
        $impersonateRedirectRoute = $this->getModuleOptions()->getImpersonateRedirectRoute();
        if (!empty($impersonateRedirectRoute)) {
            return $this->redirect()->toRoute($impersonateRedirectRoute);
        }
    }

    public function unimpersonateAction() {
        // Stop impersonating the currently impersonated user.
        $this->getImpersonateService()->unimpersonate();

        // Redirect to the post impersonation redirect route, if specified in config.
        $unimpersonateRedirectRoute = $this->getModuleOptions()->getUnImpersonateRedirectRoute();
        if (!empty($unimpersonateRedirectRoute)) {
            return $this->redirect()->toRoute($unimpersonateRedirectRoute);
        }
    }

}
