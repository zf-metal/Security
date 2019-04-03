<?php

namespace ZfMetal\Security\Validator;

use Zend\Validator\AbstractValidator;

class EmailExist extends AbstractValidator {

    /**
     * Error constants
     */
    const ERROR_EMAIL_NOT_FOUND = 'emailNotFound';

    /**
     * @var array Message templates
     */
    protected $messageTemplates = array(
        self::ERROR_EMAIL_NOT_FOUND => "Email no existe",
    );

    /**
     * @var \ZfMetal\Security\Repository\UserRepository
     */
    protected $userRepository;

    function __construct(array $options = null) {

        parent::__construct($options);
    }

    function getUserRepository() {
        if(!$this->userRepository){
            throw new Exception("UserRepository not was set.");
        }
        return $this->userRepository;
    }

    function setUserRepository(\ZfMetal\Security\Repository\UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function isValid($value, $context = null) {
        $valid = true;
        $this->setValue($value);

        $result = $this->getUserRepository()->findOneByEmail($value);
        if (!$result) {
            $valid = false;
            $this->error(self::ERROR_EMAIL_NOT_FOUND);
        }

        return $valid;
    }

}
