<?php

namespace ZfMetal\Security\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository {

    public function getAuthenticateByEmailOrUsername($username, $password) {
   
        return $this->getEntityManager()
                ->createQueryBuilder()->select('u')->from('ZfMetal\Security\Entity\User', 'u')
                ->where('u.email = :username or u.username = :username')
                ->setParameter("username", $username)
                ->getQuery()
                ->getOneOrNullResult();
           
    }
}
