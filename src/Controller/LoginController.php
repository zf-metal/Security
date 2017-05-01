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

        if ($this->getAuthService()->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }

        if ($this->getSecurityOptions()->getRememberMe() && isset($this->getRequest()->getCookie()->ZfMetalUserToken)) {
            $token = $this->getRequest()->getCookie()->ZfMetalUserToken;
            $this->forward()->dispatch(\ZfMetal\Security\Controller\RememberMeController::class, ['action' => 'remember_me', 'token' => $token]);
        }

        $form = new \ZfMetal\Security\Form\Login($this->getSecurityOptions()->getRememberMe());

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $form->setData($data);

            if ($form->isValid()) {

                $this->getAuthService()->getAdapter()->setIdentity($data['_username']);
                $this->getAuthService()->getAdapter()->setCredential($data['_password']);

                $result = $this->getAuthService()->authenticate();

                // SI remember me está activado envío la cookie

                if ($this->getSecurityOptions()->getRememberMe() && isset($data['_remember']) && $data['_remember']) {
                    $this->sendCookie($this->getAuthService()->getIdentity());
                }

                if ($result->getCode() == 1) {
                      echo "Code1".PHP_EOL;
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

    public function logoutAction() {
        $cookie = new \Zend\Http\Header\SetCookie(
                'ZfMetalUserToken', '', strtotime('-1 Year', time()), // -1 year lifetime (negative from now)
                '/'
        );
        $this->getResponse()->getHeaders()->addHeader($cookie);
        $this->authService->clearIdentity();
        $this->redirect()->toRoute('home');
    }

    private function sendCookie($identity) {

        $token = $this->stringGenerator()->generate();

        $rememberMe = new \ZfMetal\Security\Entity\RememberMe();

        $rememberMe->setToken($token);
        $rememberMe->setUser($identity);

        $this->getEm()->persist($rememberMe);
        $this->getEm()->flush();

        $cookie = new \Zend\Http\Header\SetCookie(
                'ZfMetalUserToken', $token, strtotime('+30 day', time()), // -1 year lifetime (negative from now)
                '/'
        );
        $this->getResponse()->getHeaders()->addHeader($cookie);
    }

}
