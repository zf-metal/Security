<?php

namespace ZfMetal\Security\Strategy;

use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Http\Response as HttpResponse;
use Zend\Mvc\MvcEvent;
use ZfcRbac\Exception\UnauthorizedExceptionInterface;
use ZfcRbac\Options\RedirectStrategyOptions;
use ZfcRbac\View\Strategy\AbstractStrategy;
use ZfMetal\Security\Storage\SessionStorage;

/**
 * This strategy redirects to another route when a user is unauthorized
 *
 * @author  Michaël Gallego <mic.gallego@gmail.com>
 * @license MIT
 */
class SessionRedirectStrategy extends AbstractStrategy
{
    /**
     * @var RedirectStrategyOptions
     */
    protected $options;

    /**
     * @var AuthenticationServiceInterface
     */
    protected $authenticationService;

    /**
     * @var SessionStorage
     */
    protected $sessionManager;

    /**
     * @return SessionStorage
     */
    public function getSessionManager()
    {
        return $this->sessionManager;
    }

    /**
     * SessionRedirectStrategy constructor.
     * @param RedirectStrategyOptions $options
     * @param AuthenticationServiceInterface $authenticationService
     * @param StorageSession $sessionManager
     */
    public function __construct(RedirectStrategyOptions $options, AuthenticationServiceInterface $authenticationService, SessionStorage $sessionManager)
    {
        $this->options = $options;
        $this->authenticationService = $authenticationService;
        $this->sessionManager = $sessionManager;
    }

    /**
     * @private
     * @param  MvcEvent $event
     * @return void
     */
    public function onError(MvcEvent $event)
    {
        // Do nothing if no error or if response is not HTTP response
        if (!($event->getParam('exception') instanceof UnauthorizedExceptionInterface)
            || ($event->getResult() instanceof HttpResponse)
            || !($event->getResponse() instanceof HttpResponse)
        ) {
            return;
        }

        $router = $event->getRouter();

        if ($this->authenticationService->hasIdentity()) {
            if (!$this->options->getRedirectWhenConnected()) {
                return;
            }

            $redirectRoute = $this->options->getRedirectToRouteConnected();
        } else {
            $redirectRoute = $this->options->getRedirectToRouteDisconnected();
        }

        $uri = $router->assemble([], ['name' => $redirectRoute]);

        if ($this->options->getAppendPreviousUri()) {
            $redirectKey = $this->options->getPreviousUriQueryKey();
            #$previousUri = $event->getRequest()->getUriString();
            $previousUri = $event->getRouteMatch()->getMatchedRouteName();
            $this->getSessionManager()->write($redirectKey,$previousUri);
        }

        $response = $event->getResponse() ?: new HttpResponse();

        $response->getHeaders()->addHeaderLine('Location', $uri);
        $response->setStatusCode(302);

        $event->setResponse($response);
        $event->setResult($response);
    }
}