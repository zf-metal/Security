<?php

namespace ZfMetal\Security\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractActionController
{

    /**
     *
     * @var \Zend\Authentication\AuthenticationService
     */
    private $authService;

    /**
     * LoginController constructor.
     * @param \Zend\Authentication\AuthenticationService $authService
     */
    public function __construct(\Zend\Authentication\AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

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


    public function loginAction()
    {

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

                if ($result->getCode() == 1) {
                    if ($this->getSecurityOptions()->getRedirectStrategy()->getAppendPreviousUri()) {
                        $uri = $this->getSecurityOptions()->getRedirectStrategy()->getPreviousUriQueryKey();
                        if ($this->sessionManager()->has($uri)) {
                            #return $this->redirect()->toUrl($this->sessionManager()->getFlash($uri));
                            $route = $this->sessionManager()->getFlash($uri);
                            return $this->redirect()->toRoute($route);
                        }
                    }

                    return $this->redirect()->toRoute('home');
                }

                foreach ($result->getMessages() as $mensaje) {
                    $this->flashMessenger()->addErrorMessage($mensaje);
                }
            }
        }

        return new ViewModel([
            'form' => $form->prepare(),
        ]);
    }

    public function logoutAction()
    {
        $this->authService->clearIdentity();
        $this->redirect()->toRoute('home');
    }

}
