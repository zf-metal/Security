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

    public function countAll()
    {
        $qb = $this->getEntityManager()->createQueryBuilder('t')->from('ZfMetal\Security\Entity\User', 't');
        return $qb
            ->select('count(t.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }


    public function findByRoleName($roleName) {
        return $this->getEntityManager()
            ->createQueryBuilder()->select('u')->from('ZfMetal\Security\Entity\User', 'u')
            ->leftJoin("u.roles","r")
            ->where('r.name = :roleName')
            ->setParameter("roleName", $roleName)
            ->getQuery()
            ->getResult();
    }

}
