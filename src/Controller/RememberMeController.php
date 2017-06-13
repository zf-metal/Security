<?php

namespace ZfMetal\Security\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RememberMeController extends AbstractActionController {

    /**
     *
     * @var \Zend\Authentication\AuthenticationService
     */
    private $authService;

    /**
     * LoginController constructor.
     * @param \Zend\Authentication\AuthenticationService $authService
     */
    public function __construct(\Zend\Authentication\AuthenticationService $authService) {
        $this->authService = $authService;
    }

    /**
     * getAuthService
     * @return \Zend\Authentication\AuthenticationService
     */
    function getAuthService() {
        return $this->authService;
    }

    function setAuthService(\Zend\Authentication\AuthenticationService $authService) {
        $this->authService = $authService;
    }

    public function rememberMeAction() {
        $token = $this->params('token');
        
        if (!$token) {
            throw new \Exception('Failed to read Token RememberMe');
        }

        $this->getAuthService()->getAdapter()->setToken($token);
        
        $result = $this->getAuthService()->authenticate();
        
        if ($result->getCode() == 1) {
            if ($this->getSecurityOptions()->getRedirectStrategy()->getAppendPreviousUri()) {
                $uri = $this->getSecurityOptions()->getRedirectStrategy()->getPreviousUriQueryKey();
                if ($this->sessionManager()->has($uri)) {
                    $url = $this->sessionManager()->getFlash($uri);
                    return $this->redirect()->toUrl($url);
                }
            }

            return $this->redirect()->toRoute('home');
        } else {
            $cookie = new \Zend\Http\Header\SetCookie(
                    'ZfMetalUserToken', '', strtotime('-1 Year', time()), // -1 year lifetime (negative from now)
                    '/'
            );
            $this->getResponse()->getHeaders()->addHeader($cookie);
        }

        #return $this->redirect()->toRoute('zf-metal.user/login');
    }

}
