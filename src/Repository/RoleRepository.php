<?php

namespace ZfMetal\Security\Repository;

use Doctrine\ORM\EntityRepository;

class RoleRepository extends EntityRepository {

    public function saveRole(\ZfMetal\Security\Entity\Role $role){
        $this->getEntityManager()->persist($role);
        $this->getEntityManager()->flush();
        return $role;
    }
    
     public function removeUser(\ZfMetal\Security\Entity\Role $role){
        $this->getEntityManager()->remove($role);
        $this->getEntityManager()->flush();
        return $role;
    }
}
