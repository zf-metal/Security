<?php

namespace ZfMetal\Security\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RegisterController extends AbstractActionController {

    /**
     *
     * @var \ZfMetal\Security\Options\ModuleOptions
     */
    protected $moduleOptions;

    /**
     *
     * @var \ZfMetal\Security\Repository\UserRepository
     */
    protected $userRepository;

    function __construct(\ZfMetal\Security\Options\ModuleOptions $moduleOptions, \ZfMetal\Security\Repository\UserRepository $userRepository) {
        $this->moduleOptions = $moduleOptions;
        $this->userRepository = $userRepository;
    }

    function setModuleOptions(\ZfMetal\Security\Options\ModuleOptions $moduleOptions) {
        $this->moduleOptions = $moduleOptions;
    }

    function setUserRepository(\ZfMetal\Security\Repository\UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function registerAction() {
        if (!$this->moduleOptions->getPublicRegister()) {
            $this->redirect()->toRoute('home');
        }
        
        $user = new \ZfMetal\Security\Entity\User();
        
        $form = new \ZfMetal\Security\Form\Register();
        $form->setHydrator(new \DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity($this->getEm()));
        $form->bind($user);
        
        $errors = '';

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                $user = $this->prepareUser($form->getData());
                $this->userRepository->saveUser($user);
                $this->redirect()->toRoute('home') . $user->getId();
            } else {
                $errors = $form->getMessages();
            }
        }

        return new ViewModel([
            'errors' => $errors,
            'form' => $form
        ]);
    }

}
