<?php 
namespace App\Http;

use App\Http\Response;

class ErrorResponse extends Response
{
    protected const SUCCESS = false;

    public function __construct(
        private string $message = "Что-то пошло не так",
        $code = 500
    ) {
        $this->code = $code;
    }

    protected function payload(): array
    {
        return ['message' => $this->message];
    }
}