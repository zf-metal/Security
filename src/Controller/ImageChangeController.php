<?php

namespace ZfMetal\Security\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZfMetal\Security\Entity\User;
use ZfMetal\Security\Form\ImageForm;

class ImageChangeController extends AbstractActionController {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     *
     * @var ImageForm
     */
    private $form;


    /**
     * @var User
     */
    private $user;

    function getEm() {
        return $this->em;
    }

    /**
     * @return \ZfMetal\Security\Repository\UserRepository
     */
    public function getUserRepository()
    {
        return $this->getEm()->getRepository(User::class);
    }

    public function getIdentityUser()
    {
        if(!$this->user){
            $user = $this->Identity();
            $this->user = $this->getUserRepository()->find($user->getId());
        }

        return $this->user;
    }


    /**
     * ImageChangeController constructor.
     * @param \Doctrine\ORM\EntityManager $em
     * @param ImageForm $form
     */
    public function __construct(\Doctrine\ORM\EntityManager $em, ImageForm $form)
    {
        $this->em = $em;
        $this->form = $form;
    }




    public function imageChangeAction() {



        if (!$this->getIdentityUser()) {
            return $this->redirect()->toRoute('home');
        }
        

        
        if ($this->request->isPost()) {


            $data = array_merge_recursive(
                    $this->getRequest()->getPost()->toArray(), $this->getRequest()->getFiles()->toArray()
            );

            $this->form->setHydrator(new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($this->getEm()));

            $this->form->bind($this->getIdentityUser());
            $this->form->setData($data);

            if ($this->form->isValid()) {

                $this->getUserRepository()->saveUser($this->getIdentityUser());
                $this->getAuthService()->getIdentity()->setImg($this->getIdentityUser()->getImg());

                $this->flashMessenger()->addSuccessMessage('La imagen se actualizó correctamente.');

            } else {

                foreach ($this->form->getMessages() as $message) {
                    $this->flashMessenger()->addErrorMessage($message);
                }

            }
        }

        return new ViewModel([
            'user' => $this->getIdentityUser(),
            'formImg' => $this->form
        ]);
    }


}
