<?php

namespace ZfMetal\Security\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProfileController extends AbstractActionController
{

    /**
     *
     * @var \Zend\Authentication\AuthenticationService
     */
    private $authService;

    /**
     * @var ModuleOptions
     */
    private $moduleOptions;

    /**
     * getAuthService
     * @return \Zend\Authentication\AuthenticationService
     */
    function getAuthService()
    {
        return $this->authService;
    }

    function setAuthService(\Zend\Authentication\AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    function __construct(\Zend\Authentication\AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    public function passwordAction()
    {
        $form = new \ZfMetal\Security\Form\ResetPasswordManual();
    }

    /**
     * @return ModuleOptions
     */
    public function getModuleOptions()
    {
        return $this->moduleOptions;
    }

    public function profileAction()
    {
        if (!$this->getAuthService()->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }
        $user = $this->getAuthService()->getIdentity();
        foreach ($user->getGroups() as $group){
            echo '<li>'. $group->getName(). '</li>';
        }
        return new ViewModel([
            'user' => $this->getAuthService()->getIdentity()
        ]);
    }

}
