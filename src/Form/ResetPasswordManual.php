<?php

namespace ZfMetal\Security\Form;

use Zend\Form\Form;

class ResetPasswordManual extends \Zend\Form\Form {

    public function __construct() {
        parent::__construct('ResetPasswordManual');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', "form");
        $this->setAttribute('role', "form");

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
            'name' => 'password_verify',
            'attributes' => array(
                'type' => 'password',
                'placeholder' => 'Verificar Password',
                'class' => 'form-control input-lg'
            ),
            'options' => array(
                'label' => 'Verificar Password',
                'required' => 'required'
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

    public function inputFilter() {

        $inputFilter = new \Zend\InputFilter\InputFilter();
        $factory = new \Zend\InputFilter\Factory();

        $inputFilter->add($factory->createInput(array(
                    'name' => 'password',
                    'required' => true,
                    'validators' => array(
                        [
                            'name' => 'Zend\Validator\Identical',
                            'options' => ['token' =>  'password_verify'],
                        ],
                    ),
        )));

        return $inputFilter;
    }

}