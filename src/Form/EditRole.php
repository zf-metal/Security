<?php

namespace ZfMetal\Security\Form;

use Zend\Form\Form;

class EditRole extends \Zend\Form\Form {

    public function __construct(\Doctrine\ORM\EntityManager $em, $id) {
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
            'options' => [
                'object_manager' => $em,
                'target_class' => 'ZfMetal\Security\Entity\Role',
                'property' => 'name',
                'is_method' => true,
                'find_method' => [
                    'name' => 'getDistinctRoles',
                    'params' => [
                        'id' => $id,
                    ],
                ],
            ],
        ]);

        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectMultiCheckbox',
            'name' => 'permissions',
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
