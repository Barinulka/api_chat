<?php 
declare(strict_types= 1);

namespace App\Exception;

use Exception;

class BaseAppException extends Exception
{
    private array $data = [];

    public function __construct($message = "", array $data = [], $code = 500)
    {
        parent::__construct($message, $code);
        $this->data = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }
}