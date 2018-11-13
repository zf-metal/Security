<?php

namespace ZfMetal\Security\Services;

use Zend\Authentication\Storage\StorageInterface;
use ZfMetal\Security\Entity\User;

class Impersonate
{


    /**
     * @var \Zend\Authentication\AuthenticationService
     */
    protected $authService;


    /**
     * @var \ZfMetal\Security\Options\ModuleOptions
     */
    protected $securityOptions;


    /**
     * @var \ZfMetal\Security\Repository\UserRepository
     */
    protected $userRepository;


    /**
     * The storage container in which the 'impersonator' (real user) is stored whilst they are impersonating another
     * user.
     *
     * @var \Zend\Authentication\Storage\StorageInterface
     */
    protected $storageForImpersonator;

    /**
     * Store the user as an object (true) or id (false)
     *
     * @var bool
     */
    protected $storeUserAsObject;

    /**
     * Impersonate constructor.
     *
     * @param \Zend\Authentication\AuthenticationService $authService
     * @param \ZfMetal\Security\Options\ModuleOptions $securityOptions
     * @param \ZfMetal\Security\Repository\UserRepository $userRepository
     * @param \Zend\Authentication\Storage\StorageInterface $storageForImpersonator
     * @param bool $storeUserAsObject
     */
    public function __construct(\Zend\Authentication\AuthenticationService $authService, \ZfMetal\Security\Options\ModuleOptions $securityOptions, \ZfMetal\Security\Repository\UserRepository $userRepository, \Zend\Authentication\Storage\StorageInterface $storageForImpersonator, $storeUserAsObject)
    {
        $this->authService = $authService;
        $this->securityOptions = $securityOptions;
        $this->userRepository = $userRepository;
        $this->storageForImpersonator = $storageForImpersonator;
        $this->storeUserAsObject = $storeUserAsObject;
    }


    /**
     * Begin impersonation of the user identified by the supplied user id.
     *
     * The specified user becomes the current user, such that for all intents and purposes they are now the logged-in
     * user. The 'impersonator' (real user) can be restored, and impersonation ended, by calling unimpersonate().
     *
     * @param string $userId
     */
    public function impersonate($userId)
    {
        // Ensure that there is a current user (i.e. the user is logged in).
        if (!$this->authService->getIdentity()) {
            throw new \Exception("UserNotLoggedInException");
        }

        // Retrieve the user to impersonate.
        $userToImpersonate = $this->getUserRepository()->find($userId);

        // Assert that the user to impersonate is valid.
        if (!$userToImpersonate instanceof User) {
            // User not found.
            throw new \Exception("UserNotFoundException");
        }

        // Store the 'impersonator' (real user) in storage to allow later unimpersonation.
        $this->getStorageForImpersonator()->write($this->getAuthService()->getIdentity());

        // Config setting determines whether to write the whole object to the session
        // or just the ID
        if (!$this->getStoreUserAsObject()) {
            $userToImpersonate = $userToImpersonate->getId();
        }

        // Start impersonation by overwriting the identity stored in auth storage. Essentially, this sets the user to
        // impersonate as the logged-in user.
        $this->getAuthService()->getStorage()->write($userToImpersonate);
    }

    /**
     * End impersonation.
     *
     * The 'impersonator' (real user) becomes the current user once more, such that they are now the logged-in user.
     * The identity of the user that was impersonated is cleared, leaving them logged-out.
     */
    public function unimpersonate()
    {
        // Assert that impersonation is in progress (i.e. the current user is being impersonated).
        if (!$this->isImpersonated()) {
            throw new \Exception("NotImpersonatingException");
        }

        // Retrieve the 'impersonator' (real user) from storage.
        $impersonatorUser = $this->getStorageForImpersonator()->read();

        // Assert that the 'impersonator' (real user) is valid.
        if (!$impersonatorUser instanceof User) {
            // The 'impersonator' (real user) is not the correct type.
            throw new \DomainException(
                '$$impersonatorUser is not an instance of UserInterface',
                500
            );
        }

        // Config setting determines whether to write the whole object to the session
        // or just the ID
        if (!$this->getStoreUserAsObject()) {
            $impersonatorUser = $impersonatorUser->getId();
        }


        // End impersonation by restoring the original identity - the 'impersonator' (real user) - to auth storage.
        $this->getAuthService()->getStorage()->write($impersonatorUser);

        // Clear the 'impersonator' (real user) from storage.
        $this->getStorageForImpersonator()->clear();
    }

    /**
     * Return true if impersonation is in progress (i.e. the current user is being impersonated).
     *
     * @return boolean
     */
    public function isImpersonated()
    {
        // If the 'impersonator' (real user) storage is empty, the current user is not being impersonated.
        return !$this->getStorageForImpersonator()->isEmpty();
    }

    /**
     * Get the storage container for the 'impersonator' (real user).
     *
     * Session storage is used by default unless a different storage adapter has been set.
     *
     * @return \Zend\Authentication\Storage\StorageInterface
     */
    public function getStorageForImpersonator()
    {
        return $this->storageForImpersonator;
    }

    /**
     * Set the storage container for the 'impersonator' (real user).
     *
     * Session storage is used by default unless a different storage adapter has been set.
     *
     * @param  \Zend\Authentication\Storage\StorageInterface $storageForImpersonator
     */
    public function setStorageForImpersonator(StorageInterface $storageForImpersonator)
    {
        // Set the storage container.
        $this->storageForImpersonator = $storageForImpersonator;
    }

    /**
     * Get the setting for storing user to the session as object (rather than ID)
     *
     * @return bool
     */
    public function getStoreUserAsObject()
    {
        return $this->storeUserAsObject;
    }

    /**
     * Set the setting for storing user to the session as object (rather than ID)
     *
     * @param bool $storeAsObject
     */
    public function setStoreUserAsObject($storeAsObject)
    {
        $this->storeUserAsObject = $storeAsObject;
    }

    /**
     * @return \ZfMetal\Security\Options\ModuleOptions
     */
    public function getSecurityOptions()
    {
        return $this->securityOptions;
    }

    /**
     * @param \ZfMetal\Security\Options\ModuleOptions $securityOptions
     */
    public function setSecurityOptions($securityOptions)
    {
        $this->securityOptions = $securityOptions;
    }

    /**
     * @return \ZfMetal\Security\Options\ModuleOptions
     */
    public function getUserRepository()
    {
        return $this->userRepository;
    }

    /**
     * @param \ZfMetal\Security\Options\ModuleOptions $userRepository
     */
    public function setUserRepository($userRepository)
    {
        $this->userRepository = $userRepository;
    }





}

