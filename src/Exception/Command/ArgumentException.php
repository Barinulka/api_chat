<?php 
namespace App\Exception\Command;

use App\Exception\BaseAppException;

class ArgumentException extends BaseAppException
{
    public function __construct($message = "Аргумент не найден", $data = [], $code = 0) {
        parent::__construct($message, $data, $code);
    }
}