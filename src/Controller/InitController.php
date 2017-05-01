<?php

namespace ZfMetal\Security\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class InitController extends AbstractActionController {

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * LoginController constructor.
     * @param \Zend\Authentication\AuthenticationService $authService
     */
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }

    function getEm() {
        return $this->em;
    }

    public function startAction() {
        //Roles
        $role1 = new \ZfMetal\Security\Entity\Role();
        $role1->setName("guest");
        $role2 = new \ZfMetal\Security\Entity\Role();
        $role2->setName("user");
        $role2->addChild($role1);
        $role3 = new \ZfMetal\Security\Entity\Role();
        $role3->setName("admin");
        $role3->addChild($role2);



        $permission1 = new \ZfMetal\Security\Entity\Permission("general-view");
        $permission2 = new \ZfMetal\Security\Entity\Permission("general-edit");
        $permission3 = new \ZfMetal\Security\Entity\Permission("general-admin");


        $role1->addPermission($permission1);
        $role2->addPermission($permission2);
        $role3->addPermission($permission3);

        $adminUser = new \ZfMetal\Security\Entity\User();
        $adminUser->setUsername("admin");
        $adminUser->setEmail("admin@zfmetal.com");
        $adminUser->addRole($role3);
        $adminUser->setActive(true);
        $adminUser->setName("admin");
        //admin.123
        $adminUser->setPassword('$2y$12$F/ogKP3Ggqkz/P3a6Iv5POkrKJNCbbVW8U/vDlbRCzR.ctRIV1pZ6');


        $this->getEm()->persist($permission1);
        $this->getEm()->persist($permission2);
        $this->getEm()->persist($permission3);
        $this->getEm()->persist($role1);
        $this->getEm()->persist($role2);
        $this->getEm()->persist($role3);
        $this->getEm()->persist($adminUser);
        $this->getEm()->flush();
        
        return [];
    }

    public function iniciarAction() {
          //Roles
        $role1 = new \ZfMetal\Security\Entity\Role();
        $role1->setName("invitado");
        $role2 = new \ZfMetal\Security\Entity\Role();
        $role2->setName("usuario");
        $role2->addChild($role1);
        $role3 = new \ZfMetal\Security\Entity\Role();
        $role3->setName("admin");
        $role3->addChild($role2);



        $permission1 = new \ZfMetal\Security\Entity\Permission("general-ver");
        $permission2 = new \ZfMetal\Security\Entity\Permission("general-editar");
        $permission3 = new \ZfMetal\Security\Entity\Permission("general-admin");


        $role1->addPermission($permission1);
        $role2->addPermission($permission2);
        $role3->addPermission($permission3);

        $adminUser = new \ZfMetal\Security\Entity\User();
        $adminUser->setUsername("admin");
        $adminUser->setEmail("admin@zfmetal.com");
        $adminUser->addRole($role3);
        //admin.123
        $adminUser->setPassword('$2y$12$F/ogKP3Ggqkz/P3a6Iv5POkrKJNCbbVW8U/vDlbRCzR.ctRIV1pZ6');


        $this->getEm()->persist($permission1);
        $this->getEm()->persist($permission2);
        $this->getEm()->persist($permission3);
        $this->getEm()->persist($role1);
        $this->getEm()->persist($role2);
        $this->getEm()->persist($role3);
        $this->getEm()->persist($adminUser);
        $this->getEm()->flush();
        
        return [];
    }

}
