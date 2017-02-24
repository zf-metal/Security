<?php

namespace ZfMetal\Security\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository {

    public function getAuthenticateByEmailOrUsername($username) {
   
        return $this->getEntityManager()
                ->createQueryBuilder()->select('u')->from('ZfMetal\Security\Entity\User', 'u')
                ->where('u.email = :username or u.username = :username')
                ->setParameter("username", $username)
                ->getQuery()
                ->getOneOrNullResult();
           
    }
    
    public function saveUser(\ZfMetal\Security\Entity\User $user){
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
        return $user;
    }
    
     public function removeUser(\ZfMetal\Security\Entity\User $user){
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
        return $user;
    }
}
