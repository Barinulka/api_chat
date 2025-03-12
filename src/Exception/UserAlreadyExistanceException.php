<?php 
namespace App\Exception;

use App\Exception\BaseAppException;

class UserAlreadyExistanceException extends BaseAppException
{
    public function __construct($message = "Такой пользователь уже существует", $data = [], $code = 409) {
        parent::__construct($message, $data, $code);
    }
}