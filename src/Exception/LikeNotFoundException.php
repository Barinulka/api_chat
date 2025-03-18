<?php

namespace App\Exception;

use App\Exception\BaseAppException;

class LikeNotFoundException extends BaseAppException
{
    public function __construct($message = "Не удалось найти информацию по лайкам", $code = 404)
    {
        parent::__construct($message, $code);
    }
}