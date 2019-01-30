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

        $user = $this->Identity();

        if (!$user) {
            return $this->redirect()->toRoute('home');
        }
        

        
        if ($this->request->isPost()) {


            $data = array_merge_recursive(
                    $this->getRequest()->getPost()->toArray(), $this->getRequest()->getFiles()->toArray()
            );

            $this->form->setHydrator(new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($this->getEm()));

            $this->form->bind($user);
            $this->form->setData($data);

            if ($this->form->isValid()) {

                $this->getUserRepository()->saveUser($user);
                $this->getAuthService()->getIdentity()->setImg($user->getImg());

                $this->flashMessenger()->addSuccessMessage('La imagen se actualizó correctamente.');

            } else {

                foreach ($this->form->getMessages() as $message) {
                    $this->flashMessenger()->addErrorMessage($message);
                }

            }
        }

        return new ViewModel([
            'user' => $user,
            'formImg' => $this->form
        ]);
    }


}
