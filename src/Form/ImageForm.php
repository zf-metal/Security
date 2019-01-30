<?php

namespace ZfMetal\Security\Form;

use Zend\Form\Form;

class ImageForm extends \Zend\Form\Form implements \Zend\InputFilter\InputFilterProviderInterface
{




    public function __construct()
    {


        parent::__construct('ImageForm');

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
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => "Subir",
                'class' => 'btn btn-success btn-block',
            ),
            'options' => array(
                'label' => 'Subir',
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
            'img' => [
                'required' => true,
                'filters' => [
                    ['name' => \ZfMetal\Security\Filter\RenameUpload::class,
                        "options" =>
                            [
                                "target" => \ZfMetal\Security\Constants::IMG_PATH,
                                "randomize" => true,
                                "use_upload_extension" => true,
                            ]
                    ],
                ],
                'validators' => [
                    [
                        'name' => 'FileSize',
                        'options' => [
                            'max' => "2MB",
                        ],
                    ],
                    [
                        'name' => 'FileMimeType',
                        'options' => [
                            'image/gif', 'image/jpg', 'image/png', 'image/jpeg'
                        ],
                    ],
                    [
                        'name' => 'FileImageSize',
                        'options' => [
                            'maxWidth' => 1024, 'maxHeight' => 768,
                        ],
                    ],
                ],
            ]
        ];
    }

}
