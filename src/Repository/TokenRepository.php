<?php

namespace ZfMetal\Security\Repository;

use Doctrine\ORM\EntityRepository;

class TokenRepository extends EntityRepository {

    public function getTokenByUserId($user) {
        return $this->getEntityManager()
                ->createQueryBuilder()->select('u')->from('ZfMetal\Security\Entity\Token', 'u')
                ->where('u.user = :user')
                ->setParameter("user", $user)
                ->getQuery()
                ->getOneOrNullResult();
    }

    public function getTokenByUserIdAndToken($user, $token) {
        return $this->getEntityManager()
            ->createQueryBuilder()->select('u')->from('ZfMetal\Security\Entity\Token', 'u')
            ->where('u.user = :user and u.token = :token')
            ->setParameter("user", $user)
            ->setParameter("token", $token)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function saveToken(\ZfMetal\Security\Entity\Token $token){

        $obj = $this->getTokenByUserId($token->getUser());
        if($obj){
            $obj->setToken($token->getToken());
            $token = $obj;
        }
        $this->getEntityManager()->persist($token);
        $this->getEntityManager()->flush();
        return $token;
    }

    public function removeToken(\ZfMetal\Security\Entity\Token $token)
    {
        $this->getEntityManager()->remove($token);
        $this->getEntityManager()->flush();
        return true;
    }
}
