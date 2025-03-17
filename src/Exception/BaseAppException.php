<?php 
declare(strict_types= 1);

namespace App\Exception;

use Exception;

class BaseAppException extends Exception
{
    public function __construct($message = "", $code = 500)
    {
        parent::__construct($message, $code);
    }
}