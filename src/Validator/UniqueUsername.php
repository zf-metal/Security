<?php
/**
 * Created by PhpStorm.
 * User: afurgeri
 * Date: 22/03/18
 * Time: 15:25
 */

namespace ZfMetal\Security\Validator;


use Zend\Validator\AbstractValidator;
use Zend\Validator\Exception;
use ZfMetal\Security\Entity\User;

class UniqueUsername extends AbstractValidator
{
    /**
     * Error constants
     */
    const ERROR_USERNAME_EXIST = 'errorUsernameExist';

    protected $messageTemplates = array(
        self::ERROR_USERNAME_EXIST => "El usuario ya existe en otro registro",
    );

    protected $id;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    function getEm()
    {
        if (!$this->em) {
            throw new \Exception("Entity Manager not was set.");
        }
        return $this->em;
    }

    function setEm(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Returns true if and only if $value meets the validation requirements
     *
     * If $value fails validation, then this method returns false, and
     * getMessages() will return an array of messages that explain why the
     * validation failed.
     *
     * @param  mixed $value
     * @return bool
     * @throws Exception\RuntimeException If validation of $value is impossible
     */
    public function isValid($value)
    {
        $query = $this->getEm()->createQueryBuilder()
            ->select('count(u.id)')
            ->from(User::class, 'u')
            ->where('u.username = :username')
            ->setParameter('username', $value);

        if ($this->id != null)
            $query->andWhere('u.id <> :id')
                ->setParameter('id', $this->id);

        $result = $query->getQuery()->getSingleResult()[1];

        if ($result > 0) {
            $this->error(self::ERROR_USERNAME_EXIST);
            return false;
        }

        return true;
    }

    public function __construct(\Doctrine\ORM\EntityManager $em, $id = null)
    {
        parent::__construct();
        $this->em = $em;
        $this->id = $id;
    }
}