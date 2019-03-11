<?php

namespace ZfMetal\Security\Form;

use Doctrine\Common\Persistence\ObjectManager;
use Zend\Form\Form;
use ZfMetal\Security\Entity\User;
use ZfMetal\Security\Validator\UniqueEmail;
use ZfMetal\Security\Validator\UniqueUsername;

class Register extends \Zend\Form\Form
    implements
    \DoctrineModule\Persistence\ObjectManagerAwareInterface,
    \Zend\InputFilter\InputFilterProviderInterface
{

    /**
     * @var ObjectManager
     */
    public $objectManager = null;

    /**
     * @return ObjectManager
     */
    public function getObjectManager()
    {
        return $this->objectManager;
    }

    /**
     * @param ObjectManager $objectManager
     */
    public function setObjectManager(\Doctrine\Common\Persistence\ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function __construct()
    {
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


    /**
     * Should return an array specification compatible with
     * {@link Zend\InputFilter\Factory::createInputFilter()}.
     *
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return [
            'username' => [
                'required' => true,
                "validators" => [
                    [
                        'name' => 'NoObjectExists',
                        'options' => [
                            'fields' => 'username',
                            'object_repository' => User::class,
                            'messages' => [
                                'objectFound' => 'El nombre de usuario ya existe.'
                            ]
                        ]

                    ]
                ],
            ],
            'email' => [
                'required' => true,
                "validators" => [
                    [
                        'name' => 'NoObjectExists',
                        'options' => [
                            'fields' => 'email',
                            'object_repository' => User::class,
                            'messages' => [
                                'objectFound' => 'El email ya existe.'
                            ]
                        ]

                    ]
                ],
            ]
        ];
    }

}
