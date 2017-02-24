<?php

namespace ZfMetal\Security\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AdminUserController extends AbstractActionController {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \ZfMetal\Security\DataGrid\DataGrid
     */
    protected $dataGrid;

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

    function __construct(\Doctrine\ORM\EntityManager $em, \ZfMetal\Security\DataGrid\DataGrid $dataGrid, \ZfMetal\Security\Options\ModuleOptions $moduleOptions, \ZfMetal\Security\Repository\UserRepository $userRepository) {
        $this->em = $em;
        $this->dataGrid = $dataGrid;
        $this->moduleOptions = $moduleOptions;
        $this->userRepository = $userRepository;
    }

    function getDataGrid() {
        return $this->dataGrid;
    }

    function setDataGrid(\ZfMetal\Security\DataGrid\DataGrid $dataGrid) {
        $this->dataGrid = $dataGrid;
    }

    function getEm() {
        return $this->em;
    }

    function getModuleOptions() {
        return $this->moduleOptions;
    }

    function getUserRepository() {
        return $this->userRepository;
    }

    function setEm(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }

    function setModuleOptions(\ZfMetal\Security\Options\ModuleOptions $moduleOptions) {
        $this->moduleOptions = $moduleOptions;
    }

    function setUserRepository(\ZfMetal\Security\Repository\UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function abmAction() {
        $params = $this->getRequest()->getQuery();
        $this->dataGrid->prepare();




        return ["dataGrid" => $this->dataGrid];
    }

    public function createAction() {
        $user = new \ZfMetal\Security\Entity\User();

        $form = new \ZfMetal\Security\Form\CreateUser($this->getEm());
        $form->setHydrator(new \DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity($this->getEm()));
        $form->bind($user);

        $errors = '';

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                $user = $form->getData();
                $user->setPassword($this->bcrypt()->encode($user->getPassword()));
                $this->userRepository->saveUser($user);
                $this->redirect()->toRoute('zf-metal.admin/users/view', array('id' => $user->getId()));
            } else {
                $errors = $form->getMessages();
            }
        }

        return ["form" => $form];
    }

    public function editAction() {

        $id = $this->params("id");

        $user = $this->userRepository->find($id);

        if (!$user) {
            throw new Exception("User not found");
        }


        $form = new \ZfMetal\Security\Form\EditUser($this->getEm());
        $form->setHydrator(new \DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity($this->getEm()));
        $form->bind($user);

        $errors = '';

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                $user = $form->getData();
                $user->setPassword($this->bcrypt()->encode($user->getPassword()));
                $this->userRepository->saveUser($user);
                $this->redirect()->toRoute('zf-metal.admin/users/view', array('id' => $user->getId()));
            } else {
                $errors = $form->getMessages();
            }
        }

        return ["form" => $form];
    }

    public function delAction() {
        $id = $this->params("id");
        $user = $this->userRepository->find($id);
        if (!$user) {
            throw new Exception("User not Found");
        }
        $this->userRepository->removeUser($user);
        $this->redirect()->toRoute('zf-metal.admin/users');
    }

    public function viewAction() {
        $id = $this->params("id");

        $user = $this->userRepository->find($id);

        return ["user" => $user];
    }

    public function resetPasswordAction() {
        $id = $this->params("id");

        $user = $this->userRepository->find($id);

        $formManual = new \ZfMetal\Security\Form\ResetPasswordManual();
        $formAuto = new \ZfMetal\Security\Form\ResetPasswordAuto();
        $formAuto->setAttribute("action", '/admin/users/reset-password-auto/' . $id);

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $formManual->setData($data);
            $formManual->setInputFilter($formManual->inputFilter());
            if ($formManual->isValid()) {

                $user->setPassword($this->bcrypt()->encode($data['password']));
                $this->userRepository->saveUser($user);
                $this->flashMessenger()->addSuccessMessage('Password reset exitoso.');
                $this->redirect()->toRoute('zf-metal.admin/users');
            }
        }

        return ["formManual" => $formManual, "formAuto" => $formAuto, "user" => $user];
    }

    public function resetPasswordAutoAction() {
        $id = $this->params("id");
        $user = $this->userRepository->find($id);

        $newPassword = $this->stringGenerator()->generate();

        if (!$newPassword) {
            throw new \Exception('Falla al generar nueva clave');
        }

        $user->setPassword($this->bcrypt()->encode($newPassword));

        try {
            $this->userRepository->saveUser($user);
            $this->flashMessenger()->addSuccessMessage('Password reset exitoso.');
            $this->flashMessenger()->addSuccessMessage('Usuario: ' . $user->getUsername() . " - Password: " . $newPassword);

            //*** ENVIAR MAIL CUANDO ESTE EL MODULO DE MAIL

            $this->redirect()->toRoute('zf-metal.admin/users');
        } catch (Exception $ex) {
            $this->flashMessenger()->addErrorMessage('Falla al intentar hacer reset password');
        }


        return ["user" => $user];
    }

}
