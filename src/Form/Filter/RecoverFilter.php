<?php

namespace ZfMetal\Security\Form\Filter;

use Zend\InputFilter\InputFilter;

/**
 * Description of RecoverFilter
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class RecoverFilter extends InputFilter{
   
    /**
     *
     * @var \ZfMetal\Security\Validator\EmailExist
     */
    protected $emailExist;
    
    function __construct(\ZfMetal\Security\Validator\EmailExist $emailExist) {
        $this->setEmailExist($emailExist);
        
        $this->add(array(
            'name'       => 'email',
            'required'   => true,
            'validators' => array(
                array(
                    'name' => 'EmailAddress'
                ),
                $this->getEmailExist()
            ),
        ));
        
    }
    
    function getEmailExist() {
        if(!$this->emailExist){
            throw new Exception("Validator EmailExist not set");
        }
        return $this->emailExist;
    }

    function setEmailExist(\ZfMetal\Security\Validator\EmailExist $emailExist) {
        $this->emailExist = $emailExist;
    }



}
