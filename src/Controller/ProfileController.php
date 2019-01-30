<?php

namespace ZfMetal\Security\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProfileController extends AbstractActionController {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     *
     * @var \Zend\Authentication\AuthenticationService
     */
    private $authService;


    /**
     * @return \ZfMetal\Security\Repository\UserRepository
     */
    public function getUserRepository()
    {
        return $this->getEm()->getRepository(User::class);
    }

    function __construct(\Doctrine\ORM\EntityManager $em, \Zend\Authentication\AuthenticationService $authService) {
        $this->em = $em;
        $this->authService = $authService;
    }

    
    function getEm() {
        return $this->em;
    }

    function getAuthService() {
        return $this->authService;
    }

    public function profileAction() {
        if (!$this->getAuthService()->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }
        $formImg = new \ZfMetal\Security\Form\ImageProfile($this->getSecurityOptions()->getProfilePicturePath());
        if ($this->request->isPost()) {
            $user = $this->getUserRepository()->find($this->getAuthService()->getIdentity()->getId());

            $data = array_merge_recursive(
                    $this->getRequest()->getPost()->toArray(), $this->getRequest()->getFiles()->toArray()
            );

            $formImg->setHydrator(new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($this->getEm()));
            $formImg->bind($user);
            $formImg->setData($data);

            if ($formImg->isValid()) {
                $this->getUserRepository()->saveUser($user);
                $this->getAuthService()->getIdentity()->setImg($user->getImg());
                $this->flashMessenger()->addSuccessMessage('La imagen se actualizó correctamente.');
            } else {
                foreach ($formImg->getMessages() as $message) {
                    $this->flashMessenger()->addErrorMessage($message);
                }
            }
        }

        return new ViewModel([
            'user' => $this->getAuthService()->getIdentity(),
            'formImg' => $formImg
        ]);
    }

    /**
     * @deprecated move to PasswordChangeController
     * @return \Zend\Http\Response|ViewModel
     */
    public function resetPasswordAction() {
        if (!$this->getAuthService()->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }
        $user = $this->authService->getIdentity();

        $formManual = new \ZfMetal\Security\Form\PasswordChangeForm();

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $formManual->setData($data);
            $formManual->setInputFilter($formManual->inputFilter());
            if ($formManual->isValid()) {
                $user = $this->getUserRepository()->find($this->getAuthService()->getIdentity()->getId());
                $user->setPassword($this->bcrypt()->encode($data['password']));
                $this->getUserRepository()->saveUser($user);
                $this->flashMessenger()->addSuccessMessage('Password Update exitoso.');
                $this->redirect()->toRoute('zf-metal.user/profile');
            }
        }

        return new ViewModel(["formManual" => $formManual, "user" => $user]);
    }

}
