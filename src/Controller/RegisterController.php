<?php

namespace ZfMetal\Security\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RegisterController extends AbstractActionController {

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
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    function __construct(\Doctrine\ORM\EntityManager $em, \ZfMetal\Security\Options\ModuleOptions $moduleOptions, \ZfMetal\Security\Repository\UserRepository $userRepository) {
        $this->em = $em;
        $this->moduleOptions = $moduleOptions;
        $this->userRepository = $userRepository;
    }

    function setModuleOptions(\ZfMetal\Security\Options\ModuleOptions $moduleOptions) {
        $this->moduleOptions = $moduleOptions;
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
        if (!$this->moduleOptions->getPublicRegister()) {
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
                if ($this->moduleOptions->isEmailConfirmationRequire()) {
                    $user->setActive(false);
                    $this->userRepository->saveUser($user);

                    $result = $this->notifyUser($user);
                    if ($result) {
                        $message = 'El usuario fue creado correctamente. Verifique su casilla de Email.';
                    }
                } else {
                    $user->setActive($this->moduleOptions->getUserStateDefault());
                    $this->userRepository->saveUser($user);
                    $message = 'El usuario fue creado correctamente. ';
                    if (!$this->moduleOptions->getUserStateDefault()) {
                        $message .= 'Pronto habilitaremos su acceso.';
                    }
                }
                $this->flashMessage()->addSuccess($message);
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

    public function nofityUser(\ZfMetal\Security\Entity\User $user) {
        $token = $this->stringGenerator()->geterate();
        $link = ('/user/register/validator/' . $user->getId() . '/' . $token);

        $this->mailManager()->setTemplate('zf-metal/mail/validate', ["user" => $user, "link" => $link]);
        $this->mailManager()->setFrom('noreply@sondeos.com.ar');
        $this->mailManager()->addTo($user->getEmail(), $user->getName());
        $this->mailManager()->setSubject('Validar Usuario - SYSTU');

        if ($this->mailManager()->send()) {
            $this->flashMessenger()->addSuccessMessage('Envio de mail exitoso.');
        } else {
            $this->flashMessenger()->addErrorMessage('Falla al enviar mail.');
            $this->logger()->info("Falla al enviar mail al resetear password.");
        }
    }

    public function validateAction() {
        echo var_dump($this->params('id'), $this->params("token")) . PHP_EOL;
        echo ('/user/register/validator/' . $this->params('id') . '/' . $this->params('token'));
        die;
    }

}
