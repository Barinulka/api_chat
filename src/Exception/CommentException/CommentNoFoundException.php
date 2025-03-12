<?php 
namespace App\Exception\CommentException;

use App\Exception\BaseAppException;

class CommentNoFoundException extends BaseAppException
{
    public function __construct($message = "Комментарий не найден", $data = [], $code = 404)
    {
        parent::__construct($message, $data, $code);
    }
}