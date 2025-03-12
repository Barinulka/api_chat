<?php
namespace App\Exception\PostException;

use App\Exception\BaseAppException;

class PostNotFoundException extends BaseAppException
{
    public function __construct($message = "Не удалось найти запись", $data = [], $code = 0) {
        parent::__construct($message, $data, $code);
    }
}