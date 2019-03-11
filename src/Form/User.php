<?php

namespace ZfMetal\Security\Form;

use Doctrine\Common\Persistence\ObjectManager;
use ZfMetal\Security\Entity\Group;
use ZfMetal\Security\Entity\Role;

class User extends \Zend\Form\Form
    implements
    \DoctrineModule\Persistence\ObjectManagerAwareInterface,
    \Zend\InputFilter\InputFilterProviderInterface
{


    /**
     * @var ObjectManager
     */
    public $objectManager = null;


    public function __construct()
    {
        parent::__construct('user');
        $this->setAttribute('method', 'post');


    }

    public function init(){
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
                'object_manager' => $this->getObjectManager(),
                'target_class' => Role::class,
                'property' => 'name',
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
                'object_manager' => $this->getObjectManager(),
                'target_class' => Group::class,
                'property' => 'name',
            ],
        ]);

        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => "Submit",
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
                            'object_repository' => \ZfMetal\Security\Entity\User::class,
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
                            'object_repository' => \ZfMetal\Security\Entity\User::class,
                            'messages' => [
                                'objectFound' => 'El email ya existe.'
                            ]
                        ]

                    ]
                ],
            ]
        ];
    }
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
}
