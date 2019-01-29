<?php

namespace ZfMetal\Security\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mail;

class RecoveryController extends AbstractActionController {

    /**
     * @var \ZfMetal\Security\Repository\UserRepository
     */
    private $userRepository;

    /**
     * @var \ZfMetal\Security\Form\Recover
     */
    private $form;

    /**
     * RecoverController constructor.
     * @param $userRepository
     */
    public function __construct($userRepository, \ZfMetal\Security\Form\Recover $form) {
        $this->userRepository = $userRepository;
        $this->form = $form;
    }

    /**
     * @return mixed
     */
    public function getUserRepository() {
        return $this->userRepository;
    }

    /**
     * @param mixed $userRepository
     */
    public function setUserRepository($userRepository) {
        $this->userRepository = $userRepository;
    }

    public function recoveryAction() {
        /* @var $form \Zend\Form\Form */
        $form = $this->form;

        $errors = '';

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $form->setData($data);


            if ($form->isValid()) {
                $user = $this->getUserRepository()->findOneByEmail($data['email']);
                $result = $this->updatePasswordUserAndNotify($user);
                if ($result) {
                    $this->redirect()->toRoute('zf-metal.user/login');
                } else {
                    $this->redirect()->toRoute('zf-metal.user/recovery');
                }
            } else {
                $errors = $form->getMessages();
            }
        }

        return new ViewModel([
            'errors' => $errors,
            'form' => $form
        ]);
    }

    public function okAction() {
        return [];
    }

    public function errorAction() {

        return [];
    }

    public function updatePasswordUserAndNotify(\ZfMetal\Security\Entity\User $user) {
        $newPassword = $this->stringGenerator()->generate();

        if (!$newPassword) {
            $this->logger()->err("Falla al generar nueva clave");
            throw new \Exception('Falla al generar nueva clave');
        }

        $user->setPassword($this->bcrypt()->encode($newPassword));
        try {
            $this->userRepository->saveUser($user);
        } catch (Exception $ex) {
            $this->logger()->err("Falla al intentar guardar en la DB cambio de password");
        }


        $result = $this->notifyUser($user, $newPassword);
        return $result;
    }

    public function notifyUser(\ZfMetal\Security\Entity\User $user, $newPassword) {
        $this->mailManager()->setTemplate('zf-metal/security/mail/reset', ["user" => $user, "newPassowrd" => $newPassword]);
        $this->mailManager()->setFrom($this->getSecurityOptions()->getMailFrom());
        $this->mailManager()->addTo($user->getEmail(), $user->getName());
        $this->mailManager()->setSubject('Recuperación de contraseña de '. $this->getSecurityOptions()->getHttpHost());

        if ($this->mailManager()->send()) {
            $this->flashMessenger()->addSuccessMessage('Recuperación Exitosa. Se envio un mail a la cuenta registrada con nuevos datos de acceso.');
            return true;
        } else {
            $this->flashMessenger()->addErrorMessage('Recuperación Fallida. Hubo un problema al intentar recuperar su acceso. Contactar al administrador.');
            $this->logger()->info("Falla al enviar mail al resetear password.");
            return false;
        }
    }

}
