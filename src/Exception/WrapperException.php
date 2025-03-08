<?php 
namespace App\Exception;

use App\Exception\BaseAppException;
use Exception;

class WrapperException extends BaseAppException
{
    public function __construct(Exception $exception) 
    {
        parent::__construct($exception->getMessage(), $exception->getCode(), []);
    }
}