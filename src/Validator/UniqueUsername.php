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

class UniqueUsername extends AbstractValidator
{
    /**
     * @var \ZfMetal\Security\Repository\UserRepository
     */
    protected $userRepository;

    function getUserRepository()
    {
        if (!$this->userRepository) {
            throw new \Exception("UserRepository not was set.");
        }
        return $this->userRepository;
    }

    function setUserRepository(\ZfMetal\Security\Repository\UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
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

        $result = $this->getUserRepository()->findOneBy(array('username' => $value));

        if($result){
            $this->error("Usuario duplicado");
            return false;
        }

        return true;
    }

    public function __construct(\ZfMetal\Security\Repository\UserRepository $userRepository)
    {
        parent::__construct();
        $this->setUserRepository($userRepository);
    }
}