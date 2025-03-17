<?php 
namespace App\Exception;

use App\Exception\BaseAppException;

class InvalidArgumentException extends BaseAppException
{
    public function __construct(
        $message = "Недопустимый аргумент", 
        $code = 400
    ) {
        parent::__construct($message, $code);
    }
}