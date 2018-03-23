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

class UniqueEmail extends AbstractValidator
{

    /**
     * Error constants
     */
    const ERROR_EMAIL_EXIST = 'errorEmailExist';

    protected $messageTemplates = array(
        self::ERROR_EMAIL_EXIST => "El email ya existe en otro registro",
    );

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
        $result = $this->getEm()->getRepository(User::class)->findOneBy(array('email' => $value));
        if ($result) {
            $this->error(self::ERROR_EMAIL_EXIST);
            return false;
        }

        return true;
    }

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        parent::__construct();
        $this->em = $em;
    }
}