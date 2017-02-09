<?php

namespace ZfMetal\Security\Form;

use Zend\Form\Form;

class Login extends \Zend\Form\Form {

    public function __construct() {       
        parent::__construct('login');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', "form-horizontal");
        $this->setAttribute('role', "form");       

        $this->add(array(
            'name' => '_username',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Username'
            ),
            'options' => array(
                'label' => 'Username',
            )
        ));
        $this->add(array(
            'name' => '_password',
            'attributes' => array(
                'type' => 'password',
                'placeholder' => 'Password'
            ),
            'options' => array(
                'label' => 'Password',
            )
        ));

        
          $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            
            'attributes' => array(
                'value' => "submit",
                'class' => 'btn btn-lg btn-primary',
            ),
                  'options' => array(
                'label' => 'Submit',
            )
        ));
    }




}
