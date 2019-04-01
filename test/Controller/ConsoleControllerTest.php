<?php

namespace Test\Controller;

use Doctrine\ORM\EntityManager;
use ZfMetal\Security\Entity\User;

class UserControllerTest extends \Zend\Test\PHPUnit\Controller\AbstractConsoleControllerTestCase {


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

    }

    /**
     * Se genera la estructura de la base de datos (Creacion de tablas)
     */
    public function testGenerateStructure()
    {

        $this->dispatch('orm:schema-tool:update --force');
        $this->assertResponseStatusCode(0);
    }



    public function testPopulate()
    {

        $this->dispatch('initsec english');
        $this->assertResponseStatusCode(0);
    }






}