<?php

namespace ZfMetal\Security\Form\Filter;

use Zend\InputFilter\InputFilter;

/**
 * Description of RecoverFilter
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class ImageProfileFilter extends InputFilter {

    function __construct() {
        $path = __DIR__ . '/../../../../../../public/img/profile/';
        $path = "/home/afurgeri/Proyectos/zend3/public/img/profile/";
       // $path = "/tmp";
        $this->add(array(
            'name' => 'picture',
            'required' => true,
            'filters' => array(
                array('name' => \Zend\Filter\File\RenameUpload::class,
                    "options" =>
                        [
                        "target" => $path,
                        "randomize" => true,
                        "use_upload_extension" => true,
                        "use_upload_name" => true,
                        "overwrite" => true
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
        ));
    }

}
