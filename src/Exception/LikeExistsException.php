<?php

namespace App\Exception;

use App\Exception\BaseAppException;

class LikeExistsException extends BaseAppException
{
    public function __construct($message = "Лайк не может быть добавлен более 1 раза", $code = 400)
    {
        parent::__construct($message, $code);
    }
}