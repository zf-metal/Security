<?php

namespace ZfMetal\Security\Form;

use Zend\Form\Form;

class CreateRole extends \Zend\Form\Form {

    public function __construct(\Doctrine\ORM\EntityManager $em) {
        parent::__construct('role');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', "form");
        $this->setAttribute('role', "form");

        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Name',
                'class' => 'form-control',
                'required' => 'required'
            ),
            'options' => array(
                'label' => 'Name',
            )
        ));

        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectMultiCheckbox',
            'name' => 'children',
            'attributes' => array(
                'class' => 'form-control'
            ),
            'options' => [
                'object_manager' => $em,
                'target_class' => 'ZfMetal\Security\Entity\Role',
                'property' => 'name',
            ],
        ]);

        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectMultiCheckbox',
            'name' => 'permissions',
             'attributes' => array(
                'class' => 'form-control'
            ),
            'options' => [
                'object_manager' => $em,
                'target_class' => 'ZfMetal\Security\Entity\Permission',
                'property' => 'name',
            ],
        ]);

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
