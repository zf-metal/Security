<?php

namespace ZfMetal\Security\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Console\Request as ConsoleRequest;

class InitController extends AbstractActionController
{

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * LoginController constructor.
     * @param \Zend\Authentication\AuthenticationService $authService
     */
    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    function getEm()
    {
        return $this->em;
    }


    public function initsecAction()
    {


        $request = $this->getRequest();

        if (!$request instanceof ConsoleRequest) {
            throw new RuntimeException('You can only use this action from a console!');
        }

        if ("spanish" == $this->params('lang')) {
           return $this->iniciar();
        } else if ("english" == $this->params('lang')) {
           return  $this->start();
        } else {
            return "Parameter lang no set, must be 'spanish' or 'english'";
        }

    }

    public function start()
    {
        //Roles
        try {


            $role1 = new \ZfMetal\Security\Entity\Role();
            $role1->setName("guest");
            $role2 = new \ZfMetal\Security\Entity\Role();
            $role2->setName("user");
            $role2->addChild($role1);
            $role3 = new \ZfMetal\Security\Entity\Role();
            $role3->setName("admin");
            $role3->addChild($role2);


            $permission1 = new \ZfMetal\Security\Entity\Permission("general-guest");
            $permission2 = new \ZfMetal\Security\Entity\Permission("general-user");
            $permission3 = new \ZfMetal\Security\Entity\Permission("general-admin");


            //invitado
            $role1->addPermission($permission1);
            //Usuario
            $role2->addPermission($permission2);
            $role2->addPermission($permission1);
            //Admin
            $role3->addPermission($permission3);
            $role3->addPermission($permission2);
            $role3->addPermission($permission1);

            $adminUser = new \ZfMetal\Security\Entity\User();
            $adminUser->setUsername("admin");
            $adminUser->setEmail("admin@zfmetal.com");
            $adminUser->addRole($role3);
            $adminUser->setActive(true);
            $adminUser->setName("admin");
            //admin.123
            $adminUser->setPassword($this->bcrypt()->encode("admin.123"));


            $this->getEm()->persist($permission1);
            $this->getEm()->persist($permission2);
            $this->getEm()->persist($permission3);
            $this->getEm()->persist($role1);
            $this->getEm()->persist($role2);
            $this->getEm()->persist($role3);
            $this->getEm()->persist($adminUser);
            $this->getEm()->flush();
        } catch (\Exception $e) {
            return "Fail: " . $e->getMessage();
        }

        return "Ok";
    }

    public function iniciar()
    {
        //Roles
        try {
            $role1 = new \ZfMetal\Security\Entity\Role();
            $role1->setName("invitado");
            $role2 = new \ZfMetal\Security\Entity\Role();
            $role2->setName("usuario");
            $role2->addChild($role1);
            $role3 = new \ZfMetal\Security\Entity\Role();
            $role3->setName("admin");
            $role3->addChild($role2);


            $permission1 = new \ZfMetal\Security\Entity\Permission("general-invitado");
            $permission2 = new \ZfMetal\Security\Entity\Permission("general-usuario");
            $permission3 = new \ZfMetal\Security\Entity\Permission("general-admin");

            //invitado
            $role1->addPermission($permission1);
            //Usuario
            $role2->addPermission($permission2);
            $role2->addPermission($permission1);
            //Admin
            $role3->addPermission($permission3);
            $role3->addPermission($permission2);
            $role3->addPermission($permission1);

            $adminUser = new \ZfMetal\Security\Entity\User();
            $adminUser->setUsername("admin");
            $adminUser->setEmail("admin@zfmetal.com");
            $adminUser->addRole($role3);
            $adminUser->setActive(true);
            $adminUser->setName("admin");
            //admin.123
            $adminUser->setPassword($this->bcrypt()->encode("admin.123"));


            $this->getEm()->persist($permission1);
            $this->getEm()->persist($permission2);
            $this->getEm()->persist($permission3);
            $this->getEm()->persist($role1);
            $this->getEm()->persist($role2);
            $this->getEm()->persist($role3);
            $this->getEm()->persist($adminUser);
            $this->getEm()->flush();

        } catch (\Exception $e) {
            return "Fail: " . $e->getMessage();
        }

        return "Ok";
    }

}
