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
     * RecoverController constructor.
     * @param $userRepository
     */
    public function __construct($userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return mixed
     */
    public function getUserRepository()
    {
        return $this->userRepository;
    }

    /**
     * @param mixed $userRepository
     */
    public function setUserRepository($userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function recoveryAction() {

        $form = new \ZfMetal\Security\Form\Recover();

        $errors = '';

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $form->setData($data);

            if ($form->isValid()) {
                $user = $this->validateEmail($data['mail']);
                $result = $this->updatePasswordUserAndNotify($user);

                $this->redirect()->toRoute('home');
            } else {
                $errors = $form->getMessages();
            }
        }

        return new ViewModel([
            'errors' => $errors,
            'form' => $form
        ]);
    }

    public function validateEmail($email)
    {
        $user = $this->userRepository->getAuthenticateByEmailOrUsername($email);
        if(!$user){
            throw new \Exception('El mail no está registrado');
        }
        return $user;
    }

    public function updatePasswordUserAndNotify(\ZfMetal\Security\Entity\User $user)
    {
        $newPassword = $this->stringGenerator()->generate();

        if(!$newPassword){
            throw new \Exception('Falla al generar nueva clave');
        }

        $user->setPassword($this->bcrypt()->encode($newPassword));
        $user = $this->userRepository->saveUser($user);

        $result = $this->notifyUser($user, $newPassword);
        return $result;
    }

    public function notifyUser(\ZfMetal\Security\Entity\User $user, $newPassword)
    {
        $mail = new Mail\Message();
        $mail->setBody('Your New Password is: '. $newPassword);
        $mail->setFrom('sisty@sondeos.org', 'SYSTU');
        $mail->addTo($user->getEmail(), $user->getName());
        $mail->setSubject('Password Recovery');

        $transport = new Mail\Transport\Sendmail('noreply@example.com');
        $result = $transport->send($mail);

        return $result;
    }
}
