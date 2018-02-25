<?php

namespace ZfMetal\Security\Options;

use Zend\Stdlib\AbstractOptions;
use ZfcRbac\Options\RedirectStrategyOptions;

/**
 */
class ModuleOptions extends AbstractOptions {

    /**
     * Enable Public Register
     *
     * @var boolean
     */
    protected $publicRegister = true;

    /**
     * Enable Password Recovery
     *
     * @var boolean
     */
    protected $passwordRecovery = true;

    /**
     * mail from default
     *
     * @var boolean
     */
    protected $mailFrom = "info.zfmetal@gmail.com";

    /**
     * @var int
     */
    protected $bcryptCost = 12;

    /**
     * Options for the redirect strategy
     *
     * @var \ZfcRbac\Options\RedirectStrategyOptions
     */
    protected $redirectStrategy;

    /**
     * @var boolean
     */
    protected $userStateDefault;

    /**
     * @var boolean
     */
    protected $emailConfirmationRequire;

    /**
     * @var string
     */
    protected $profilePicturePath;

    /**
     * @var string
     */
    protected $profilePicturePathRelative;

    /**
     * @var boolean
     */
    protected $rememberMe;

    /**
     * @var string
     */
    protected $roleDefault;
    
    
      /**
     * @var string
     */
    protected $savedUserRedirectRoute = 'zf-metal.admin/users/view';

    /**
     * @var boolean
     */

    protected $checkDb = true;
    
    /**
     * Constructor
     */
    public function __construct($options = null) {
        $this->__strictMode__ = false;
        parent::__construct($options);
    }

    function getPublicRegister() {
        return $this->publicRegister;
    }

    function setPublicRegister($publicRegister) {
        $this->publicRegister = $publicRegister;
    }

    function getPasswordRecovery() {
        return $this->passwordRecovery;
    }

    function setPasswordRecovery($passwordRecovery) {
        $this->passwordRecovery = $passwordRecovery;
    }

    public function setRedirectStrategy(array $redirectStrategy) {
        $this->redirectStrategy = new RedirectStrategyOptions($redirectStrategy);
    }

    /**
     * Get the redirect strategy options
     *
     * @return \ZfcRbac\Options\RedirectStrategyOptions
     */
    public function getRedirectStrategy() {
        if (null === $this->redirectStrategy) {
            $this->redirectStrategy = new RedirectStrategyOptions();
        }

        return $this->redirectStrategy;
    }

    /**
     * @return bool
     */
    public function getUserStateDefault() {
        return $this->userStateDefault;
    }

    /**
     * @param bool $userStateDefault
     */
    public function setUserStateDefault($userStateDefault) {
        $this->userStateDefault = $userStateDefault;
    }

    /**
     * @return bool
     */
    public function getEmailConfirmationRequire() {
        return $this->emailConfirmationRequire;
    }

    public function setEmailConfirmationRequire($emailConfirmationRequire) {
        $this->emailConfirmationRequire = $emailConfirmationRequire;
    }

    /**
     * @return int
     */
    public function getBcryptCost() {
        return $this->bcryptCost;
    }

    /**
     * @param int $bcryptCost
     */
    public function setBcryptCost($bcryptCost) {
        $this->bcryptCost = $bcryptCost;
    }

    /**
     * @return mixed
     */
    public function getProfilePicturePath() {
        return $this->profilePicturePath;
    }

    /**
     * @param mixed $profilePicturePath
     */
    public function setProfilePicturePath($profilePicturePath) {
        $this->profilePicturePath = $profilePicturePath;
    }

    /**
     * @return mixed
     */
    public function getProfilePicturePathRelative() {
        return $this->profilePicturePathRelative;
    }

    /**
     * @param mixed $profilePicturePath
     */
    public function setProfilePicturePathRelative($profilePicturePathRelative) {
        $this->profilePicturePathRelative = $profilePicturePathRelative;
    }

    function getRememberMe() {
        return $this->rememberMe;
    }

    function setRememberMe($rememberMe) {
        $this->rememberMe = $rememberMe;
    }

    function getMailFrom() {
        return $this->mailFrom;
    }

    function setMailFrom($mailFrom) {
        $this->mailFrom = $mailFrom;
        return $this;
    }
    function getRoleDefault() {
        return $this->roleDefault;
    }

    function setRoleDefault($roleDefault) {
        $this->roleDefault = $roleDefault;
    }

    function getSavedUserRedirectRoute() {
        return $this->savedUserRedirectRoute;
    }

    function setSavedUserRedirectRoute($savedUserRedirectRoute) {
        $this->savedUserRedirectRoute = $savedUserRedirectRoute;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCheckDb()
    {
        return $this->checkDb;
    }

    /**
     * @param mixed $checkDb
     */
    public function setCheckDb($checkDb)
    {
        $this->checkDb = $checkDb;
    }



}
