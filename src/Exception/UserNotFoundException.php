<?php 
namespace App\Exception;

use App\Exception\BaseAppException;

class UserNotFoundException extends BaseAppException
{
    public function __construct($message = "Пользователь не найден", $data = [], $code = 404)
    {
        parent::__construct($message, $data, $code);
    }
}