<?php 
namespace App\Exception\Command;

use App\Exception\BaseAppException;

class CommandException extends BaseAppException
{
    public function __construct($message = "Обязательный аргумент не указан", $data=[], $code = 400)
    {
        parent::__construct($message, $data, $code);
    }
}