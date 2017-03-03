<?php
namespace ZfMetal\Security\Filter;

class RenameUpload extends \Zend\Filter\File\RenameUpload {
    
    public function filter($value)
    {
        $result = parent::filter($value);
        
        return basename($result['tmp_name']);
    }
}
