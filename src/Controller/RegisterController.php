<?php

namespace ZfMetal\Security\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RegisterController extends AbstractActionController {


    /**
     *
     * @var \ZfMetal\Security\Repository\UserRepository
     */
    protected $userRepository;

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    function __construct(\Doctrine\ORM\EntityManager $em, \ZfMetal\Security\Repository\UserRepository $userRepository) {
        $this->em = $em;
        $this->userRepository = $userRepository;
    }



    function setUserRepository(\ZfMetal\Security\Repository\UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    function getEm() {
        return $this->em;
    }

    function setEm(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }

    public function registerAction() {
        if (!$this->getSecurityOptions()->getPublicRegister()) {
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
                $user->setPassword($this->bcrypt()->encode($user->getPassword()));

                $message = '';
                if ($this->getSecurityOptions()->getEmailConfirmationRequire()) {
                    $user->setActive(0);
                    $this->userRepository->saveUser($user);
                    $this->flashMessenger()->addSuccessMessage('El usuario fue creado correctamente. Requiere activación via email.');
                       
                    
                    if($this->notifyUser($user)) {
                        $this->flashMessenger()->addSuccessMessage('Envio de mail exitoso. Verifique su casilla de Email para activar el usuario.');
                    }else{
                        $this->flashMessenger()->addErrorMessage('Envio de mail fallido. Contacte al administrador.');
      
                    }
                    
                    
                } else {
                    $user->setActive($this->getSecurityOptions()->getUserStateDefault());
                    $this->userRepository->saveUser($user);
                    
                    $this->flashMessenger()->addSuccessMessage('El usuario fue creado correctamente.');

                    if (!$this->getSecurityOptions()->getUserStateDefault()) {
                        $this->flashMessenger()->addWarningMessage('El usuario debe ser habilitado por un administrador.');
                    }
                }
                $this->redirect()->toRoute('zf-metal.user/login');
            } else {
                $errors = $form->getMessages();
            }
        }

        return new ViewModel([
            'errors' => $errors,
            'form' => $form
        ]);
    }

    public function notifyUser(\ZfMetal\Security\Entity\User $user)
    {
        $token = $this->stringGenerator()->generate();

        $link = $this->url()->fromRoute('zf-metal.user/register/validate', ['id'=>$user->getId(),'token'=> $token], ['force_canonical'=>true]);

        $tokenObj = new \ZfMetal\Security\Entity\Token();

        $tokenObj->setUser($user)
            ->settoken($token);

        $tokenRepository = $this->em->getRepository(\ZfMetal\Security\Entity\Token::class);

        $tokenRepository->saveToken($tokenObj);

        $this->mailManager()->setTemplate('zf-metal/security/mail/validate', ["user" => $user, "link" => $link]);
        $this->mailManager()->setFrom('noreply@sondeos.com.ar');
        $this->mailManager()->addTo($user->getEmail(), $user->getName());
        $this->mailManager()->setSubject('Validar Usuario - SYSTU');

        if ($this->mailManager()->send()) {
            return true;
        } else {
            $this->logger()->err("Falla al enviar mail al usuario al notificar confirmación.");
             return false;
        }
    }

    public function validateAction() {
        $id = $this->params('id');
        $token = $this->params("token");

        $tokenRepository = $this->em->getRepository(\ZfMetal\Security\Entity\Token::class);

        $tokenObj = $tokenRepository->getTokenByUserIdAndToken($id, $token);

        if(!$tokenObj){
            return $this->forward()->dispatch(\ZfMetal\Security\Controller\RegisterController::class, array('action' => 'errorToken'));
        }

        $user = $this->userRepository->find($id);

        if($user){
            $user->setActive(true);
            $this->userRepository->saveUser($user);
            $tokenRepository->removeToken($tokenObj);
            $this->flashMessenger()->addSuccessMessage('Token validado exitosamente.');
        }

        $this->redirect()->toRoute('zf-metal.user/login');
    }

    public function errorTokenAction(){
        return new ViewModel(
            'ZfMetal\Security\Register\error-token'
        );
    }
}
