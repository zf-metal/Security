<?php

namespace ZfMetal\Security\Form\Filter;

use Zend\InputFilter\InputFilter;
use ZfMetal\Security\Validator\UniqueUsername;

class UserEdit extends InputFilter {

    function __construct(\Doctrine\ORM\EntityManager $em, $id) {

        $this->add(array(
            'name' => 'username',
            'required' => true,
            'validators' => array(
                new UniqueUsername($em, $id)
            ),
        ));

        $this->add(array(
            'name' => 'groups',
            'required' => false,
        ));
    }

}
