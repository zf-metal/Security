<?php

namespace ZfMetal\Security;

class Module {

    const VERSION = '3.0.2dev';

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }
    
       public function getServiceConfig() {
        return include __DIR__ . '/../config/services.config.php';
    }

    public function onBootstrap(EventInterface $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $redirectStrategy = $e->getApplication()->getServiceManager()->get('ZfcRbac\View\Strategy\RedirectStrategy');

        $redirectStrategy->attach($eventManager);
    }

}
