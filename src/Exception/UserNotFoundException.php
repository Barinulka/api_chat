<?php 
namespace App\Exception;

use App\Exception\BaseAppException;

class UserNotFoundException extends BaseAppException
{
    public function __construct($message = "Пользователь не найден", $code = 404, $data = [])
    {
        parent::__construct($message, $code, $data);
    }
}