<?php

namespace ZfMetal\Security\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AdminUserController extends AbstractActionController
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \ZfMetal\DataGrid\Grid
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

    /**
     * @var \ZfcRbac\Options\ModuleOptions
     */
    protected $ZfcRbacOptions;

    function __construct(\Doctrine\ORM\EntityManager $em, \ZfMetal\DataGrid\Grid $dataGrid, \ZfMetal\Security\Options\ModuleOptions $moduleOptions, \ZfMetal\Security\Repository\UserRepository $userRepository, $ZfcRbacOptions)
    {
        $this->em = $em;
        $this->dataGrid = $dataGrid;
        $this->moduleOptions = $moduleOptions;
        $this->userRepository = $userRepository;
        $this->ZfcRbacOptions = $ZfcRbacOptions;
    }

    function getDataGrid()
    {
        return $this->dataGrid;
    }

    function setDataGrid(\ZfMetal\DataGrid\Grid $dataGrid)
    {
        $this->dataGrid = $dataGrid;
    }

    function getEm()
    {
        return $this->em;
    }

    function getModuleOptions()
    {
        return $this->moduleOptions;
    }

    /**
     * @return \ZfcRbac\Options\ModuleOptions
     */
    public function getZfcRbacOptions()
    {
        return $this->ZfcRbacOptions;
    }


    function getUserRepository()
    {
        return $this->userRepository;
    }

    function setEm(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    function setModuleOptions(\ZfMetal\Security\Options\ModuleOptions $moduleOptions)
    {
        $this->moduleOptions = $moduleOptions;
    }

    function setUserRepository(\ZfMetal\Security\Repository\UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function abmAction()
    {
        $this->dataGrid->getCrudForm()->add(new \Zend\Form\Element\Hidden("id"));
        $this->dataGrid->getCrudForm()->get('id')->setValue($this->dataGrid->getCrudForm()->getObject()->getId());

        if($this->getModuleOptions()->getPasswordColumnReset()){
            $this->dataGrid->addExtraColumn("Password",$this->getModuleOptions()->getPasswordColumnValue(),"right");
        }

        if($this->getModuleOptions()->isImpersonateColumn()){
            $this->dataGrid->addExtraColumn("Impersonar","<a href='/admin/impersonate/{{id}}'>Impersonar</a>","right");
        }

        $this->dataGrid->prepare();

        return ["dataGrid" => $this->dataGrid];
    }

    public function createAction()
    {
        $user = new \ZfMetal\Security\Entity\User();

        $form = new \ZfMetal\Security\Form\CreateUser($this->getEm(), $this->getZfcRbacOptions()->getGuestRole());
        $form->setHydrator(new \DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity($this->getEm()));
        $form->bind($user);
        $form->getInputFilter()->get('groups')->setRequired(false);
        $form->setInputFilter(new \ZfMetal\Security\Form\Filter\User($this->getEm()));


        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                $user->setPassword($this->bcrypt()->encode($user->getPassword()));
                try {
                    $this->userRepository->saveUser($user);
                    $this->flashMessenger()->addSuccessMessage('El usuario se creo correctamente');
                } catch (Exception $ex) {
                    $this->flashMessenger()->addErrorMessage('Error al crear el usuario');
                }
                $this->redirect()->toRoute($this->getSecurityOptions()->getSavedUserRedirectRoute(), array('id' => $user->getId()));
            } else {
                $errors = $form->getMessages();
            }
        }

        return ["form" => $form];
    }

    public function editAction()
    {

        $id = $this->params("id");

        $user = $this->userRepository->find($id);

        if (!$user) {
            throw new Exception("User not found");
        }

        $form = new \ZfMetal\Security\Form\EditUser($this->getEm(), $this->getZfcRbacOptions()->getGuestRole(), $this->getModuleOptions()->getEditEmailUser());
        $form->setHydrator(new \DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity($this->getEm()));
        $form->bind($user);
        $form->getInputFilter()->get('groups')->setRequired(false);
        $form->setInputFilter(new \ZfMetal\Security\Form\Filter\UserEdit($this->getEm(), $id));
        $errors = '';

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {

                try {
                    $this->userRepository->saveUser($user);
                    $this->flashMessenger()->addSuccessMessage('El usuario ' . $user->getUsername() . ' se edito correctamente');
                } catch (Exception $ex) {
                    $this->flashMessenger()->addErrorMessage('Error al editar el usuario ' . $user->getUsername());
                }


                $this->userRepository->saveUser($user);
                $this->redirect()->toRoute($this->getSecurityOptions()->getSavedUserRedirectRoute(), array('id' => $user->getId()));
            } else {
                $errors = $form->getMessages();
            }
        }

        return ["form" => $form];
    }

    public function delAction()
    {
        $id = $this->params("id");
        $user = $this->userRepository->find($id);
        if (!$user) {
            throw new Exception("User not Found");
        }

        try {
            $this->userRepository->removeUser($user);
            $this->flashMessenger()->addSuccessMessage('El Usuario se elimino correctamente.');
        } catch (Exception $ex) {
            $this->flashMessenger()->addErrorMessage('Error al eliminar el Usuario.');
        }


        $this->redirect()->toRoute('zf-metal.admin/users');
    }

    public function viewAction()
    {
        $id = $this->params("id");

        $user = $this->userRepository->find($id);

        return ["user" => $user];
    }

    public function resetPasswordAction()
    {
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

    public function resetPasswordAutoAction()
    {
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

            //*** ENVIAR MAIL 
            $this->mailManager()->setTemplate('zf-metal/mail/reset', ["user" => $user, "newPassowrd" => $newPassword]);
            $this->mailManager()->setFrom('ci.sys.virtual@gmail.com');
            $this->mailManager()->addTo($user->getEmail(), $user->getName());
            $this->mailManager()->setSubject('Recuperar Password');

            if ($this->mailManager()->send()) {
                $this->flashMessenger()->addSuccessMessage('Envio de mail exitoso.');
            } else {
                $this->flashMessenger()->addErrorMessage('Falla al enviar mail.');
                $this->logger()->info("Falla al enviar mail al resetear password.");
            }


            $this->redirect()->toRoute('zf-metal.admin/users');
        } catch (Exception $ex) {
            $this->flashMessenger()->addErrorMessage('Falla al intentar hacer reset password');
        }


        return ["user" => $user];
    }

}
