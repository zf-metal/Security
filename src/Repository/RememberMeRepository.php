<?php

namespace ZfMetal\Security\Repository;

use Doctrine\ORM\EntityRepository;

class RememberMeRepository extends EntityRepository {

    public function getUserIdByToken($token){
        return $this->getEntityManager()
            ->createQueryBuilder()->select('u')->from('ZfMetal\Security\Entity\User', 'u')
            ->innerJoin('ZfMetal\Security\Entity\RememberMe', 'r', 'WITH','u.id = r.user')
            ->where('r.token = :token')
            ->setParameter("token", $token)
            ->getQuery()
            ->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
    }

    public function saveToken(\ZfMetal\Security\Entity\RememberMe $token){

        $obj = $this->getTokenByUserId($token->getUser());
        if($obj){
            $obj->setToken($token->getToken());
            $token = $obj;
        }
        $this->getEntityManager()->persist($token);
        $this->getEntityManager()->flush();
        return $token;
    }

    public function removeToken(\ZfMetal\Security\Entity\RememberMe $token)
    {
        $this->getEntityManager()->remove($token);
        $this->getEntityManager()->flush();
        return true;
    }
}
