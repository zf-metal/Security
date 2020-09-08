<?php

namespace ZfMetal\Security;

use Zend\ModuleManager\ModuleManager;

use Zend\ModuleManager\Feature\ConsoleBannerProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\Console\Adapter\AdapterInterface as Console;

class Module implements
    ConsoleBannerProviderInterface,
    ConsoleUsageProviderInterface
{

    /**
     * @var \Zend\Mvc\Application
     */
    private $app;

    /**
     * @var \Zend\Mvc\MvcEvent
     */
    private $mvcEvent;


    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(\Zend\Mvc\MvcEvent $mvcEvent)
    {
        $this->mvcEvent = $mvcEvent;
        $this->app = $mvcEvent->getApplication();
        $this->checkDb();
        $this->setupRedirectStrategy();


        /* @var $em \Doctrine\ORM\EntityManager */
        $em = $e->getApplication()->getServiceManager()->get('doctrine.entitymanager.orm_default');
        $em->getFilters()->enable('soft-deletable');

    }

    public function getConsoleBanner(Console $console)
    {
        return "Security Module";
    }

    /**
     * This method is defined in ConsoleUsageProviderInterface
     */
    public function getConsoleUsage(Console $console)
    {
        return [
            'initsec <lang>' => 'Initialize users and roles',
        ];
    }


    private function checkDb()
    {
        if ($this->getSecurityOptions()->getCheckDb()) {

            if (php_sapi_name() == "cli") {
                //echo "Avoid checkDb from console".PHP_EOL;
                return;
            }


            try {
                /**
                 * @var $doctrine \Doctrine\ORM\EntityManager
                 */
                $doctrine = $this->getServiceManager()->get('doctrine.entitymanager.orm_default');


                //Check Connection
                $doctrine->getConnection()->connect();

                //Check table exist
                if ($this->app->getRequest() instanceof \Zend\Http\Request) {
                    $schemaManager = $doctrine->getConnection()->getSchemaManager();
                    if ($schemaManager->tablesExist(array('users')) == false) {
                        throw new \Exception('Table "users" don\'t exists');
                    }
                }

                //Check if 1 user exist

                if ($doctrine->getRepository('ZfMetal\Security\Entity\User')->countAll() == 0) {
                    throw new \Exception('Not user exist. Security module must be initialized');
                }
                echo "<h3>Security Module</h3>";
                echo "<p>Everything is fine. Turn off checkDb from Security Options.</p>".PHP_EOL;
                die;

            } catch (\Exception $e) {
                echo '<h3>Method CheckDb in Security Module</h3>';
                echo '<p>An error occurred when SecurityModule checked the db</p>';
                echo '<p>Check:</p>';
                echo '<ul>';
                echo '<li>Include and configure a doctrine.local.php file in "config/autoload/"</li>';
                echo '<li>Update you schecma. Command console: <strong>vendor/bin/doctrine-module orm:schema-tool:update --force</strong></li>';
                echo '<li>Initialize Security Module. Command console: <strong>index.php initsec lang</strong> (ex: <strong>initsec spanish</strong> | <strong>initsec english</strong>) </li>';
                echo '</ul>';
                echo '<p>Disable checkDb in security config after setup DB and Users</p>';
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


    /**
     * @return \Zend\Mvc\Application
     */
    public function getApp()
    {
        return $this->app;
    }
}
