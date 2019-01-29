<?php

namespace ZfMetal\Security\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZfMetal\Security\Entity\User;
use ZfMetal\Security\Form\Register;

class RegisterController extends AbstractActionController {


    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;


    /**
     *
     * @var Register
     */
    protected $form;

    function __construct(\Doctrine\ORM\EntityManager $em, Register $form) {
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

    function setEm(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }

    public function registerAction() {
        if (!$this->getSecurityOptions()->getPublicRegister()) {
            $this->redirect()->toRoute('home');
        }

        $user = new \ZfMetal\Security\Entity\User();


        $this->form->setHydrator(new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($this->getEm()));
        $this->form->bind($user);

        $errors = '';

        if ($this->getRequest()->isPost()) {
            $this->form->setData($this->getRequest()->getPost());

            if ( $this->form->isValid()) {
                $user->setPassword($this->bcrypt()->encode($user->getPassword()));

                $message = '';
                if ($this->getSecurityOptions()->getEmailConfirmationRequire()) {
                    $user->setActive(0);
                    $role = $this->getEm()->getRepository(\ZfMetal\Security\Entity\Role::class)->findOneBy(['name' => $this->getSecurityOptions()->getRoleDefault()]);
                    if (!$role) {
                        throw new \Exception('The role '. $this->getSecurityOptions()->getRoleDefault() . ' no exist!');
                    }
                    $user->addRole($role);
                    $this->getUserRepository()->saveUser($user);
                    $this->flashMessenger()->addSuccessMessage('El usuario fue creado correctamente. Requiere activación via email.');

                    if ($this->notifyUser($user)) {
                        $this->flashMessenger()->addSuccessMessage('Envio de mail exitoso. Verifique su casilla de Email para activar el usuario.');
                    } else {
                        $this->flashMessenger()->addErrorMessage('Envio de mail fallido. Contacte al administrador.');
                    }
                } else {
                    $role = $this->getEm()->getRepository(\ZfMetal\Security\Entity\Role::class)->findOneBy(['name' => $this->getSecurityOptions()->getRoleDefault()]);
                    if (!$role) {
                        throw new \Exception('The role '. $this->getSecurityOptions()->getRoleDefault() . ' no exist!');
                    }
                    $user->addRole($role);
                    $user->setActive($this->getSecurityOptions()->getUserStateDefault());
                    $this->getUserRepository()->saveUser($user);

                    $this->flashMessenger()->addSuccessMessage('El usuario fue creado correctamente.');

                    if (!$this->getSecurityOptions()->getUserStateDefault()) {
                        $this->flashMessenger()->addWarningMessage('El usuario debe ser habilitado por un administrador.');
                    }
                }
                $this->redirect()->toRoute('zf-metal.user/login');
            } else {
                $errors =  $this->form->getMessages();
            }
        }

        return new ViewModel([
            'errors' => $errors,
            'form' =>  $this->form
        ]);
    }

    public function notifyUser(\ZfMetal\Security\Entity\User $user) {
        $token = $this->stringGenerator()->generate();

        $link = $this->getSecurityOptions()->getHttpHost() . $this->url()->fromRoute('zf-metal.user/register/validate', ['id' => $user->getId(), 'token' => $token], ['force_canonical' => false]);

        $tokenObj = new \ZfMetal\Security\Entity\Token();

        $tokenObj->setUser($user)
            ->settoken($token);

        $tokenRepository = $this->em->getRepository(\ZfMetal\Security\Entity\Token::class);

        $tokenRepository->saveToken($tokenObj);

        $this->mailManager()->setTemplate('zf-metal/security/mail/validate', ["user" => $user, "link" => $link]);
        $this->mailManager()->setFrom('noreply@sondeos.com.ar');
        $this->mailManager()->addTo($user->getEmail(), $user->getName());
        $this->mailManager()->setSubject('Activación de cuenta de '.$this->getSecurityOptions()->getHttpHost());

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

        if (!$tokenObj) {
            return $this->forward()->dispatch(\ZfMetal\Security\Controller\RegisterController::class, array('action' => 'errorToken'));
        }

        $user = $this->getUserRepository()->find($id);

        if ($user) {
            $user->setActive(true);
            $this->getUserRepository()->saveUser($user);
            $tokenRepository->removeToken($tokenObj);
            $this->flashMessenger()->addSuccessMessage('Token validado exitosamente.');
        }

        $this->redirect()->toRoute('zf-metal.user/login');
    }

    public function errorTokenAction() {
        return new ViewModel(
            'ZfMetal\Security\Register\error-token'
        );
    }

}
