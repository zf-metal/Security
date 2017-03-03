<?php

namespace ZfMetal\Security\Form;

use Zend\Form\Form;

class ImageProfile extends \Zend\Form\Form {

    public function __construct() {
        parent::__construct('image');
        $this->setAttribute('method', 'post');
        $this->setAttribute("enctype", "multipart/form-data");
        $this->setAttribute('class', "form");
        $this->setAttribute('role', "form");

        $this->add(array(
            'name' => 'picture',
            'type' => 'Zend\Form\Element\File',
            'attributes' => array(
                'class' => 'btn btn-info btn-block',
              //  'accept' => "image/png, image/jpeg, image/gif",
            ),
            'options' => array(
                'label' => 'Img',
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
        
        
    }
    
    
    public function inputFilter() {
        $inputFilter = new \Zend\InputFilter\InputFilter();
        $factory = new \Zend\InputFilter\Factory();
        $path = __DIR__ . "/../../../../../public/img/profile/";
        $inputFilter->add($factory->createInput(array(
                    'name' => 'picture',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'filerenameupload',
                            "options" =>
                            [
                                "target" => $path,
                                "randomize" => false,
                                "use_upload_extension" => true,
                                "use_upload_name" => true,
                                "overwrite" => 0
                            ]
                        ),
                    ),
                    'validators' => array(
                        array(
                            'name' => 'FileSize',
                            'options' => array(
                                'max' => "2MB",
                            ),
                        ),
                        array(
                            'name' => 'FileMimeType',
                            'options' => array(
                                'image/gif', 'image/jpg', 'image/png', 'image/jpeg'
                            ),
                        ),
                        array(
                            'name' => 'FileImageSize',
                            'options' => array(
                                'maxWidth' => 640, 'maxHeight' => 480,
                            ),
                        ),
                    ),
        )));
        return $inputFilter;
    }
    
}
