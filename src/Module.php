<?php

namespace ZfMetal\Security;

class Module
{

    /**
     * @var \Zend\Mvc\Application
     */
    private $app;

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(\Zend\Mvc\MvcEvent $mvcEvent)
    {
        $this->app = $mvcEvent->getApplication();
        $this->checkDb();
        $this->setupRedirectStrategy();
    }

    private function checkDb()
    {
        if ($this->getSecurityOptions()->getCheckDb()) {
            try {
                /**
                 * @var $doctrine \Doctrine\ORM\EntityManager
                 */
                $doctrine = $this->getServiceManager()->get('doctrine.entitymanager.orm_default');
                $doctrine->getConnection()->connect();
            } catch (\Exception $e) {
                echo '<h3>Method CheckDb in Security Module</h3>';
                echo '<p>An error occurred when SecurityModule checked the db</p>';
                echo '<p>Please, check your doctrine db config. If not yet set, include and configure a doctrine.local.php file in "config/autoload/"</p>';
                echo '<p>Disable checkDb in security config after configure DB</p>';
                echo '<h4>Message:</h4>';
                echo "<pre>";
                echo $e->getMessage() . PHP_EOL;
                echo "</pre>";
                echo '<h4>StackTrace:</h4>';
                echo "<pre>";
                echo $e->getTraceAsString() . PHP_EOL;
                echo "</pre>";
                die;
            }
        }

    }

    private function setupRedirectStrategy()
    {
        $redirectStrategy = $this->getSessionRedirectStrategy();
        $redirectStrategy->attach($this->getEventManager());
        $sharedEventManager = $this->getEventManager()->getSharedManager();
        $rbacListener = $this->getServiceManager()->get(\ZfMetal\Security\Listener\RbacListener::class);

        $sharedEventManager->attach(
            'Zend\View\Helper\Navigation\AbstractHelper', 'isAllowed', array($rbacListener, 'accept')
        );

    }

    private function getEventManager()
    {
        return $this->app->getEventManager();
    }

    private function getServiceManager()
    {
        return $this->app->getServiceManager();
    }

    /**
     * @return \ZfMetal\Security\Strategy\SessionRedirectStrategy
     */
    private function getSessionRedirectStrategy()
    {
        return $this->getServiceManager()->get('zf-metal-security.session-redirect-stretegy');

    }

    /**
     * @return \ZfcRbac\View\Strategy\RedirectStrategy
     */
    private function getRedirectStrategy()
    {
        return $this->getServiceManager()->get('ZfcRbac\View\Strategy\RedirectStrategy');

    }

    /**
     * @return \ZfMetal\Security\Options\ModuleOptions
     */
    private function getSecurityOptions()
    {
        return $this->getServiceManager()->get('zf-metal-security.options');
    }


}
