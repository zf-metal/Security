<?php

namespace ZfMetal\Security\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RecoverController extends AbstractActionController {

    public function recoverAction() {

        $form = new \ZfMetal\Security\Form\Recover();

        $errors = '';

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
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
}
