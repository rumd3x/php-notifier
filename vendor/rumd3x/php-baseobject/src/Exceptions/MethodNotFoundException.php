<?php
namespace Rumd3x\BaseObject\Exceptions;

use Exception;
use Rumd3x\BaseObject\BaseObject;

class MethodNotFoundException extends Exception {
    
    public $instance;

    public function __construct(BaseObject $object, $message) {
        $this->instance = $object;
        parent::__construct($message);
    }
}