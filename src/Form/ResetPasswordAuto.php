<?php

namespace ZfMetal\Security\Form;

use Zend\Form\Form;

class ResetPasswordAuto extends \Zend\Form\Form {

    public function __construct() {
        parent::__construct('ResetPasswordAuto');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', "form");
        $this->setAttribute('role', "form");
        

        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => "Generación automatica y envio por mail",
                'class' => 'btn btn-lg btn-primary btn-block signup-btn',
            ),
            'options' => array(
                'label' => 'Auto Reset & Send Email',
            )
        ));
    }

}
