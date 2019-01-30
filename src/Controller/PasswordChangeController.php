<?php

namespace ZfMetal\Security\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZfMetal\Security\Form\PasswordChangeForm;

class PasswordChangeController extends AbstractActionController {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     *
     * @var PasswordChangeForm
     */
    private $form;

    /**
     * PasswordChangeController constructor.
     * @param \Doctrine\ORM\EntityManager $em
     * @param PasswordChangeForm $form
     */
    public function __construct(\Doctrine\ORM\EntityManager $em, PasswordChangeForm $form)
    {
        $this->em = $em;
        $this->form = $form;
    }


    /**
     * @return \ZfMetal\Security\Repository\UserRepository
     */
    public function getUserRepository()
    {
        return $this->getEm()->getRepository(User::class);
    }


    
    function getEm() {
        return $this->em;
    }

    /**
     * @return PasswordChangeForm
     */
    public function getForm()
    {
        return $this->form;
    }



    public function passwordChangeAction() {

        $user = $this->Identity();
        
        if (!$user) {
            return $this->redirect()->toRoute('home');
        }

        if ($this->getRequest()->isPost()) {

            $data = $this->getRequest()->getPost();
            $this->form->setData($data);

            if ($this->form->isValid()) {


                $user->setPassword($this->bcrypt()->encode($data['password']));
                $this->getUserRepository()->saveUser($user);

                $this->flashMessenger()->addSuccessMessage('Contraseña actualizada con exito.');

                $this->redirect()->toRoute('zf-metal.user/profile');
            }
        }

        return new ViewModel(["form" => $this->form, "user" => $user]);
    }

}
