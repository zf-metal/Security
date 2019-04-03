<?php

namespace ZfMetal\Security\Repository;

use Doctrine\ORM\EntityRepository;

class GroupRepository extends EntityRepository {

    
    public function saveGroup(\ZfMetal\Security\Entity\Group $group){
        $this->getEntityManager()->persist($group);
        $this->getEntityManager()->flush();
        return $group;
    }
    
     public function removeGroup(\ZfMetal\Security\Entity\Group $group){
        $this->getEntityManager()->remove($group);
        $this->getEntityManager()->flush();
        return $group;
    }
}
