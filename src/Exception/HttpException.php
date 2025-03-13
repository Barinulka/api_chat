<?php 
namespace App\Exception;

use App\Exception\BaseAppException;

class HttpException extends BaseAppException
{
    public function __construct($message = "Не удалось получить путь из запросса", $data = [], $code = 400) {
        parent::__construct($message, $data, $code);
    }
}