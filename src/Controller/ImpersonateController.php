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

    function getImpersonateService() {
        return $this->impersonateService;
    }
    
    function getModuleOptions() {
        return $this->moduleOptions;
    }


    public function impersonateUserAction() {
        // Start impersonating the user specified by the user id route parameter specified in config.
        $this->getImpersonateService()->impersonate($this->params()->fromRoute('userId'));

        // Redirect to the post impersonation redirect route, if specified in config.
        $impersonateRedirectRoute = $this->getModuleOptions()->getImpersonateRedirectRoute();
        if (!empty($impersonateRedirectRoute)) {
            return $this->redirect()->toRoute($impersonateRedirectRoute);
        }
    }

    public function unimpersonateUserAction() {
        // Stop impersonating the currently impersonated user.
        $this->getImpersonateService()->unimpersonate();

        // Redirect to the post impersonation redirect route, if specified in config.
        $unimpersonateRedirectRoute = $this->getModuleOptions()->getUnImpersonateRedirectRoute();
        if (!empty($unimpersonateRedirectRoute)) {
            return $this->redirect()->toRoute($unimpersonateRedirectRoute);
        }
    }

}
