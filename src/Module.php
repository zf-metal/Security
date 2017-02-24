<?php

namespace ZfMetal\Security;
use Zend\EventManager\EventInterface;

class Module {

    const VERSION = '3.0.2dev';

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(EventInterface $e) {
        $eventManager = $e->getApplication()->getEventManager();
//        $redirectStrategy = $e->getApplication()->getServiceManager()->get('ZfcRbac\View\Strategy\RedirectStrategy');

        $redirectStrategy = $e->getApplication()->getServiceManager()->get('zf-metal-security.session-redirect-stretegy');

        $redirectStrategy->attach($eventManager);
    }

}
