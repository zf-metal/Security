<?php

namespace ZfMetal\Security\Form;

use Zend\Form\Form;

class ImageProfile extends \Zend\Form\Form {

    public function __construct($picturePath) {
        parent::__construct('image');
        $this->setAttribute('method', 'post');
        $this->setAttribute("enctype", "multipart/form-data");
        $this->setAttribute('class', "form");
        $this->setAttribute('role', "form");

        $this->add(array(
            'name' => 'img',
            'type' => 'Zend\Form\Element\File',
            'attributes' => array(
                'class' => 'btn btn-default btn-block',
                'accept' => "image/png, image/jpeg, image/gif",
            ),
            'options' => array(
                'label' => 'Picture',
            )
        ));

        $this->add(array(
            'name' => 'submitbtn',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => "Upload",
                'class' => 'btn btn-success btn-block',
            ),
            'options' => array(
                'label' => 'Upload',
            )
        ));          
        $this->setInputFilter(new \ZfMetal\Security\Form\Filter\ImageProfileFilter($picturePath));
    }
    
    
}
