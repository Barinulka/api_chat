<?php 
namespace App\Exception;

use App\Exception\BaseAppException;

class UserAlreadyExistanceException extends BaseAppException
{
    public function __construct($message = "Такой пользователь уже существует", $code = 409) {
        parent::__construct($message, $code);
    }
}