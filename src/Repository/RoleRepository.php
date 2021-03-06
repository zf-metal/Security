<?php

namespace ZfMetal\Security\Repository;

use Doctrine\ORM\EntityRepository;

class RoleRepository extends EntityRepository {

    public function saveRole(\ZfMetal\Security\Entity\Role $role){
        $this->getEntityManager()->persist($role);
        $this->getEntityManager()->flush();
        return $role;
    }
    
     public function removeRole(\ZfMetal\Security\Entity\Role $role){
        $this->getEntityManager()->remove($role);
        $this->getEntityManager()->flush();
        return $role;
    }
    
    public function getDistinctRoles($id = null){
        return $this->getEntityManager()
                ->createQueryBuilder()->select('u')->from('ZfMetal\Security\Entity\Role', 'u')
                ->where('u.id != :id')
                ->setParameter("id", $id)
                ->getQuery()
                ->getResult();        
    }
    public function getAssignableRoles($guestRoleName = null){
        return $this->getEntityManager()
                ->createQueryBuilder()->select('u')->from('ZfMetal\Security\Entity\Role', 'u')
                ->where('u.name != :name')
                ->setParameter("name", $guestRoleName)
                ->getQuery()
                ->getResult();        
    }
}
