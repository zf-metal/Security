<?php

namespace ZfMetal\Security\Form;

use Zend\Form\Form;

class Recover extends \Zend\Form\Form {

    public function __construct() {
        parent::__construct('user');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', "form");
        $this->setAttribute('role', "form");

        
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'email',
                'placeholder' => 'Email',
                'class' => 'form-control input-lg',
                'required' => 'required'
            ),
            'options' => array(
                'label' => 'Email'
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => "Submit",
                'class' => 'btn btn-lg btn-primary btn-block signup-btn',
            ),
            'options' => array(
                'label' => 'Submit',
            )
        ));
    }

}
