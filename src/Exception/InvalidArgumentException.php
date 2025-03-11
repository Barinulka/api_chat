<?php 

use App\Exception\BaseAppException;

class InvalidArgumentException extends BaseAppException
{
    public function __construct(
        $message = "Недопустимый аргумент", 
        $data = [], 
        $code = 400
    ) {
        parent::__construct($message, $data, $code);
    }
}