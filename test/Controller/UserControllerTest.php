<?php

namespace Test\Controller;

use Doctrine\ORM\EntityManager;
use ZfMetal\Security\Entity\User;

class UserControllerTest extends \Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase {


    protected $pluginIdentity;

    protected $user;


    /**
     * Inicializo el MVC
     */
    public function setUp()
    {
        $this->setApplicationConfig(
            include __DIR__ . '/../config/application.config.php'
        );


        parent::setUp();
        $this->configureServiceManager();

    }

    /**
     * Mockeo el EntityManager sobre el contenedor de servicios
     * @param ServiceManager $services
     */
    protected function configureServiceManager()
    {
        $this->getApplicationServiceLocator()->setAllowOverride(true);
        $this->getApplicationServiceLocator()->setService(\ZfMetal\SecurityJwt\Service\JwtDoctrineIdentity::class, $this->getMockJwtDoctrineIdentity());
        //  $services->setAllowOverride(false);
    }

    public function getMockJwtDoctrineIdentity()
    {

        if (!$this->pluginIdentity) {

            $this->pluginIdentity = $this->createMock(\Zend\Authentication\AuthenticationService::class);
            $this->pluginIdentity->method('getIdentity')
                ->willReturn($this->getMockIdentity());
        }
        return $this->pluginIdentity;
    }

    public function getMockIdentity()
    {

        if (!$this->user) {
            $user = $this->getEm()->getRepository(User::class)->find(1);
            $this->user = $user;
        }
        return $this->user;
    }

    public function getEm()
    {
        return $this->getApplicationServiceLocator()->get(EntityManager::class);
    }




    public function testCreateUser(){
        $this->setUseConsoleRequest(false);

        $params = [
            "name" => "Cristian Incarnato",
            "username" => "cincarnato",
            "email" => "cristian.cdi@gmail.com",
            "phone" => "1122331122"
        ];

        $this->dispatch("/admin/users/create", "GET");


        $this->assertResponseStatusCode(200);
    }




}