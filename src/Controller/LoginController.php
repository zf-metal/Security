<?php

namespace ZfMetal\Security\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractActionController {

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

    public function loginAction() {

        if ($this->getAuthService()->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }

        $form = new \ZfMetal\Security\Form\Login();

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $form->setData($data);

            if ($form->isValid()) {

                $this->getAuthService()->getAdapter()->setIdentity($data['_username']);
                $this->getAuthService()->getAdapter()->setCredential($data['_password']);

                $result = $this->getAuthService()->authenticate();

                foreach ($result->getMessages() as $mensaje) {
                    echo $mensaje . PHP_EOL;
                }

                if ($result->getCode() == 1) {
                    $this->redirect()->toRoute('home');
                }
            }
        }

        return new ViewModel([
            'form' => $form->prepare()
        ]);
    }

    public function logoutAction() {
        $this->authService->clearIdentity();
        $this->redirect()->toRoute('login');
    }

}
