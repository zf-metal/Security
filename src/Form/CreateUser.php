<?php

namespace ZfMetal\Security\Form;

use Zend\Form\Form;

class CreateUser extends \Zend\Form\Form
{

    protected $em;

    function getEm()
    {
        return $this->em;
    }

    public function __construct(\Doctrine\ORM\EntityManager $em, $guestRole = "")
    {
        $this->em = $em;
        parent::__construct('user');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', "form");
        $this->setAttribute('role', "form");
        $this->setAttribute('autocomplete', "off");

        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Name',
                'class' => 'form-control ',
                'required' => 'required',
                'autocomplete' => "off"
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
                'class' => 'form-control ',
                'required' => 'required',
                'autocomplete' => "off"
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
                'class' => 'form-control ',
                'required' => 'required',
                'autocomplete' => "off"
            ),
            'options' => array(
                'label' => 'Username'
            )
        ));

        $this->add(array(
            'name' => 'phone',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Phone',
                'class' => 'form-control ',
            ),
            'options' => array(
                'label' => 'Phone'
            )
        ));

        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'password',
                'placeholder' => 'Password',
                'class' => 'form-control ',
                'autocomplete' => "new-password"
            ),
            'options' => array(
                'label' => 'Password',
                'required' => 'required'
            )
        ));


        $this->add(array(
            'name' => 'active',
            'type' => 'Zend\Form\Element\Checkbox',
            'attributes' => array(
                'type' => 'checkbox',
                'placeholder' => 'Active',
                'class' => '',
                'autocomplete' => "off"
            ),
            'options' => array(
                'label' => 'Active'
            )
        ));

        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectMultiCheckbox',
            'name' => 'roles',
            'attributes' => array(
                'class' => 'form-control',
                'autocomplete' => "off"
            ),
            'options' => [
                'object_manager' => $em,
                'target_class' => 'ZfMetal\Security\Entity\Role',
                'property' => 'name',
                'find_method' => [
                    'name' => 'getAssignableRoles',
                    'params' => [
                        'guestRoleName' => $guestRole,
                    ],
                ],
            ],
        ]);

        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectMultiCheckbox',
            'name' => 'groups',
            'attributes' => array(
                'class' => 'form-control',
                'autocomplete' => "off"
            ),
            'options' => [
                'object_manager' => $em,
                'target_class' => 'ZfMetal\Security\Entity\Group',
                'property' => 'name',
            ],
        ]);

        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => "Submit",
                'class' => 'btn btn-primary btn-block signup-btn',
            ),
            'options' => array(
                'label' => 'Submit',
            )
        ));
    }

}
