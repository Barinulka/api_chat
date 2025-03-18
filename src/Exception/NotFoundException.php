<?php 
namespace App\Exception;

use App\Exception\BaseAppException;
use Psr\Container\NotFoundExceptionInterface;

class NotFoundException extends BaseAppException implements NotFoundExceptionInterface
{
    public function __construct($message = "Не удалось найти файл", $code = 404) {
        parent::__construct($message, $code);
    }
}