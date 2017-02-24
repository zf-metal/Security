<?php

namespace ZfMetal\Security\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProfileController extends AbstractActionController {

    /**
     *
     * @var \Zend\Authentication\AuthenticationService
     */
    private $authService;

    /**
     * getAuthService
     * @return \Zend\Authentication\AuthenticationService
     */
    function getAuthService() {
        return $this->authService;
    }

    function setAuthService(\Zend\Authentication\AuthenticationService
    $authService) {
        $this->authService = $authService;
    }

    function __construct(\Zend\Authentication\AuthenticationService $authService) {
        $this->authService = $authService;
    }

    public function passwordAction() {
         $form= new \ZfMetal\Security\Form\ResetPasswordManual();
    }


}