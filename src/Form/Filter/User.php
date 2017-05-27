<?php

namespace ZfMetal\Security\Form\Filter;

use Zend\InputFilter\InputFilter;

class User extends InputFilter {

    function __construct() {

        $this->add(array(
            'name' => 'email',
            'required' => true,
            'validators' => array(
                array(
                    'name' => \Zend\Validator\EmailAddress::class,
                    'options' => [
                        'messages' => [
                            'emailAddressInvalid' => 'El formato de email es inválido.',
                            'emailAddressInvalidFormat' => 'El formato de email es inválido.',
                        ]
                    ]
                ),
            ),
        ));

        $this->add(array(
            'name' => 'groups',
            'required' => false,
        ));
    }

    /*
      const INVALID            = 'emailAddressInvalid';
      const INVALID_FORMAT     = 'emailAddressInvalidFormat';
      const INVALID_HOSTNAME   = 'emailAddressInvalidHostname';
      const INVALID_MX_RECORD  = 'emailAddressInvalidMxRecord';
      const INVALID_SEGMENT    = 'emailAddressInvalidSegment';
      const DOT_ATOM           = 'emailAddressDotAtom';
      const QUOTED_STRING      = 'emailAddressQuotedString';
      const INVALID_LOCAL_PART = 'emailAddressInvalidLocalPart';
      const LENGTH_EXCEEDED    = 'emailAddressLengthExceeded';
     */
}
