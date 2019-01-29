<?php

namespace ZfMetal\Security\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class JwtController extends AbstractActionController {

    /**
     *
     * @var \Zend\Authentication\AuthenticationService
     */
    private $authService;

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * LoginController constructor.
     * @param \Zend\Authentication\AuthenticationService $authService
     */
    public function __construct(\Zend\Authentication\AuthenticationService $authService, \Doctrine\ORM\EntityManager $em) {
        $this->authService = $authService;
        $this->em = $em;
    }

    /**
     * getAuthService
     * @return \Zend\Authentication\AuthenticationService
     */
    function getAuthService() {
        return $this->authService;
    }

    function getEm() {
        return $this->em;
    }

    function setAuthService(\Zend\Authentication\AuthenticationService $authService) {
        $this->authService = $authService;
    }

    public function loginAction() {

    }

    public function logoutAction() {

    }



}
