<?php

namespace ZfMetal\Security\Form;

use Zend\Form\Form;

class Register extends \Zend\Form\Form {

    public function __construct() {
        parent::__construct('user');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', "form");
        $this->setAttribute('role', "form");

        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Name',
                'class' => 'form-control input-lg',
                                'required' => 'required'

            ),
            'options' => array(
                'label' => 'Name',
            )
        ));
        
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'mail',
                'placeholder' => 'Email',
                'class' => 'form-control input-lg',
                'required' => 'required'
            ),
            'options' => array(
                'label' => 'Email'
            )
        ));
        
        $this->add(array(
            'name' => 'username',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Username',
                'class' => 'form-control input-lg',
                'required' => 'required'
            ),
            'options' => array(
                'label' => 'Username'
            )
        ));
        
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'password',
                'placeholder' => 'Password',
                'class' => 'form-control input-lg'
            ),
            'options' => array(
                'label' => 'Password',
                'required' => 'required'
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => "Register",
                'class' => 'btn btn-lg btn-primary btn-block signup-btn',
            ),
            'options' => array(
                'label' => 'Submit',
            )
        ));
    }

}
