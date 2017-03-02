<?php

namespace ZfMetal\Security\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProfileController extends AbstractActionController
{

    /**
     *
     * @var \Zend\Authentication\AuthenticationService
     */
    private $authService;

    /**
     * @var \ZfMetal\Security\Options\ModuleOptions
     */
    private $moduleOptions;

    /**
     * @var \ZfMetal\Security\Repository\UserRepository
     */
    private $userRepository;

    /**
     * ProfileController constructor.
     * @param \Zend\Authentication\AuthenticationService $authService
     * @param \ZfMetal\Security\Options\ModuleOptions $moduleOptions
     * @param \ZfMetal\Security\Repository\UserRepository $userRepository
     */
    public function __construct(\Zend\Authentication\AuthenticationService $authService, \ZfMetal\Security\Options\ModuleOptions $moduleOptions, \ZfMetal\Security\Repository\UserRepository $userRepository)
    {
        $this->authService = $authService;
        $this->moduleOptions = $moduleOptions;
        $this->userRepository = $userRepository;
    }

    /**
     * @return \Zend\Authentication\AuthenticationService
     */
    public function getAuthService()
    {
        return $this->authService;
    }

    /**
     * @return \ZfMetal\Security\Options\ModuleOptions
     */
    public function getModuleOptions()
    {
        return $this->moduleOptions;
    }

    /**
     * @return \ZfMetal\Security\Repository\UserRepository
     */
    public function getUserRepository()
    {
        return $this->userRepository;
    }

    public function profileAction()
    {
        if (!$this->getAuthService()->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }
        $user = $this->getAuthService()->getIdentity();
        foreach ($user->getGroups() as $group){
            echo '<li>'. $group->getName(). '</li>';
        }
        return new ViewModel([
            'user' => $this->getAuthService()->getIdentity()
        ]);
    }

    public function resetPasswordAction()
    {
        if (!$this->getAuthService()->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }
        $user = $this->authService->getIdentity();

        $formManual = new \ZfMetal\Security\Form\ResetPasswordManual();

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $formManual->setData($data);
            $formManual->setInputFilter($formManual->inputFilter());
            if ($formManual->isValid()) {
                $user = $this->getUserRepository()->find($this->getAuthService()->getIdentity()->getId());
                $user->setPassword($this->bcrypt()->encode($data['password']));
                $this->userRepository->saveUser($user);
                $this->flashMessenger()->addSuccessMessage('Password Update exitoso.');
                $this->redirect()->toRoute('zf-metal.user/profile');
            }
        }

        return new ViewModel(["formManual" => $formManual, "user" => $user]);
    }
}
