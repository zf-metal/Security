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
    protected $httpHost = '';

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
     * Enable Password Column Reset
     *
     * @var boolean
     */
    protected $passwordColumnReset = true;

    /**
     * Enable Password Column Value
     *
     * @var string
     */
    protected $passwordColumnValue= "<a href='/admin/users/reset-password/{{id}}'>password</a>";

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
     * @var boolean
     */

    protected $editEmailUser = false;

    /**
     * @var boolean
     */

    protected $impsersonateUserAsObject = true;

    /**
     * @var string
     */
    protected $impersonateRedirectRoute = 'home';

    /**
     * @var string
     */
    protected $unImpersonateRedirectRoute = 'home';

    /**
     * Enable Impersonate Column on User List
     *
     * @var boolean
     */
    protected $impersonateColumn = true;
    
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

    /**
     * @return bool
     */
    public function getEditEmailUser()
    {
        return $this->editEmailUser;
    }

    /**
     * @return bool
     */
    public function isEditEmailUser()
    {
        return $this->editEmailUser;
    }

    /**
     * @param bool $editEmailUser
     */
    public function setEditEmailUser($editEmailUser)
    {
        $this->editEmailUser = $editEmailUser;
    }


    /**
     * @return bool
     */
    public function getPasswordColumnReset()
    {
        return $this->passwordColumnReset;
    }


    /**
     * @return bool
     */
    public function isPasswordColumnReset()
    {
        return $this->passwordColumnReset;
    }

    /**
     * @param bool $passwordColumnReset
     */
    public function setPasswordColumnReset($passwordColumnReset)
    {
        $this->passwordColumnReset = $passwordColumnReset;
    }

    /**
     * @return string
     */
    public function getPasswordColumnValue()
    {
        return $this->passwordColumnValue;
    }

    /**
     * @param string $passwordColumnValue
     */
    public function setPasswordColumnValue($passwordColumnValue)
    {
        $this->passwordColumnValue = $passwordColumnValue;
    }


    /**
     * @return bool
     */
    public function getImpsersonateUserAsObject()
    {
        return $this->impsersonateUserAsObject;
    }

    /**
     * @return bool
     */
    public function isImpsersonateUserAsObject()
    {
        return $this->impsersonateUserAsObject;
    }

    /**
     * @param bool $impsersonateUserAsObject
     */
    public function setImpsersonateUserAsObject($impsersonateUserAsObject)
    {
        $this->impsersonateUserAsObject = $impsersonateUserAsObject;
    }

    /**
     * @return string
     */
    public function getImpersonateRedirectRoute()
    {
        return $this->impersonateRedirectRoute;
    }

    /**
     * @param string $impersonateRedirectRoute
     */
    public function setImpersonateRedirectRoute($impersonateRedirectRoute)
    {
        $this->impersonateRedirectRoute = $impersonateRedirectRoute;
    }

    /**
     * @return bool
     */
    public function isImpersonateColumn()
    {
        return $this->impersonateColumn;
    }

    /**
     * @param bool $impersonateColumn
     */
    public function setImpersonateColumn($impersonateColumn)
    {
        $this->impersonateColumn = $impersonateColumn;
    }

    /**
     * @return string
     */
    public function getUnImpersonateRedirectRoute()
    {
        return $this->unImpersonateRedirectRoute;
    }

    /**
     * @param string $unImpersonateRedirectRoute
     */
    public function setUnImpersonateRedirectRoute($unImpersonateRedirectRoute)
    {
        $this->unImpersonateRedirectRoute = $unImpersonateRedirectRoute;
    }

    /**
     * @return bool
     */
    public function isHttpHost()
    {
        return $this->httpHost;
    }

    /**
     * @param bool $httpHost
     */
    public function setHttpHost($httpHost)
    {
        $this->httpHost = $httpHost;
    }







}
