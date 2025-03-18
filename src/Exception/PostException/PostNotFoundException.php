<?php
namespace App\Exception\PostException;

use App\Exception\BaseAppException;

class PostNotFoundException extends BaseAppException
{
    public function __construct($message = "Не удалось найти запись", $code = 404) {
        parent::__construct($message,$code);
    }
}