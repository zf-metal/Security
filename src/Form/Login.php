<?php

namespace ZfMetal\Security\Form;

use Zend\Form\Form;

class Login extends \Zend\Form\Form {

    public function __construct($rememberMe) {
        parent::__construct('login');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', "form");
        $this->setAttribute('role', "form");

        $this->add(array(
            'name' => '_username',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Username',
                'class' => 'form-control ',
                'required' => 'required'
            ),
            'options' => array(
                'label' => 'Username',
            )
        ));
        $this->add(array(
            'name' => '_password',
            'attributes' => array(
                'type' => 'password',
                'placeholder' => 'Password',
                'class' => 'form-control ',
                'required' => 'required'
            ),
            'options' => array(
                'label' => 'Password',
            )
        ));

        if ($rememberMe) {
            $this->add(array(
                'name' => '_remember',
                'required' => false,
                'allow_empty' => true,
                'type' => 'Zend\Form\Element\Checkbox',
                'attributes' => array(
                    'type' => 'checkbox',
                    'placeholder' => 'Remember Me',
                    'class' => 'checkbox',
                ),
                'options' => array(
                    'label' => 'Remember Me'
                )
            ));
        }

        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => "Login",
                'class' => 'btn  btn-primary btn-block signup-btn',
            ),
            'options' => array(
                'label' => 'Submit',
            )
        ));
    }

}
